<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        if (empty($query) || strlen($query) < 2) {
            return response()->json(['users' => []]);
        }

        $users = User::where('name', 'like', '%' . $query . '%')
            ->with('profile')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy',
                    'title' => $user->profile?->title ?? 'Développeur',
                    'url' => route('profile.show', $user->id)
                ];
            });

        return response()->json(['users' => $users]);
    }
}
