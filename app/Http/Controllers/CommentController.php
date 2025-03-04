<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Notifications\CommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate(['content' => 'required|max:1000']);
        
        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        $comment->load('user.profile');
        
        // Send notification to post owner if it's not the current user
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new CommentNotification($comment, auth()->user()));
        }

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'html' => view('components.comment', compact('comment'))->render()
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);

        $validated = $request->validate(['content' => 'required|max:1000']);
        
        $comment->update(['content' => $validated['content']]);
        
        $comment->load('user.profile');

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'html' => view('components.comment', compact('comment'))->render()
        ]);
    }

    public function destroy(Comment $comment)
    {
        abort_if($comment->user_id !== auth()->id(), 403);
        
        $post_id = $comment->post_id;
        $comment_id = $comment->id;
        
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé avec succès'
        ]);
    }
} 