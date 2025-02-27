<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // Récupérer les compétences de l'utilisateur avec les années d'expérience
        $userSkills = $user->skills()->withPivot('years_experience')->get();

        return view('profile.show', compact('user', 'posts', 'connectionsCount', 'postsCount', 'userSkills'));
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
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user = auth()->user();
        $profile = $user->profile ?? $user->profile()->create();

        $avatarPath = $request->hasFile('avatar') ?
            $request->file('avatar')->store('avatars', 'public') : null;

        $coverPath = $request->hasFile('cover_image') ?
            $request->file('cover_image')->store('covers', 'public') : null;

        if ($avatarPath) {
            $profile->avatar = asset('storage/' . $avatarPath);
        }

        if ($coverPath) {
            $profile->cover_image = asset('storage/' . $coverPath);
        }

        $profile->fill($request->only([
            'title',
            'bio',
            'github_url',
            'linkedin_url',
            'website_url',
            'location'
        ]))->save();

        // Mise à jour des compétences
        if ($request->has('skills')) {
            $user->skills()->sync($request->skills);
        } else {
            $user->skills()->detach(); // Supprime toutes les compétences si aucune n'est sélectionnée
        }

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
