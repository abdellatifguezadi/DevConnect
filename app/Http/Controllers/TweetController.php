<?php

namespace App\Http\Controllers;

use App\Events\TestNotification;
use App\Models\Tweet;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{

    public function create ()  {
        return view('tweet');
    }
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'author' => 'required|string|max:255',
        'title' => 'required|string|max:255',
    ]);

    // Create the post
    $post = Tweet::create([
        'author' => $request->input('author'),
        'title' => $request->input('title'),
    ]);


    $user = User::find(Auth::id());

        $user->notify(new PostCreatedNotification($post));
    // Dispatch the event with the post data
    event(new TestNotification([
        'author' => $post->author,
        'title' => $post->title,
    ]));

    // Redirect with success message
    return redirect()->back()->with('success', 'Post created successfully!');
}
}
