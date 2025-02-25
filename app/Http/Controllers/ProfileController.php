<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function show(User $user): View
    {
        $connectionsCount = \App\Models\Connection::where(function ($query) use ($user) {
            $query->where('requester_id', $user->id)
                ->orWhere('requested_id', $user->id);
        })->where('status', 'accepted')->count();

        $posts = $user->posts()
            ->withCount(['comments', 'likes'])
            ->with(['user.profile', 'comments.user', 'hashtags'])
            ->latest()
            ->paginate(10);

        $postsCount = $user->posts()->count();

        return view('profile.show', compact('user', 'posts', 'connectionsCount', 'postsCount'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();
        $profile = $user->profile ?? $user->profile()->create();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = '/storage/' . $path;
        }

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $profile->cover_image = '/storage/' . $path;
        }

        $profile->fill($request->only([
            'title',
            'bio',
            'github_url',
            'linkedin_url',
            'website_url',
            'location'
        ]))->save();

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
