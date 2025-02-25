<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $user->load('profile', 'posts', 'skills');
        
        $connectionsCount = \App\Models\Connection::where(function ($query) use ($user) {
            $query->where('requester_id', $user->id)
                ->orWhere('requested_id', $user->id);
        })->where('status', 'accepted')->count();

        $postsCount = $user->posts()->count();

        return view('profile.show', compact('user', 'connectionsCount', 'postsCount'));
    }
}