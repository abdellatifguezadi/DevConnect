<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Events\commentNotification;
use App\Notifications\commentNotification as NotificationsCommentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Envoyer une notification au propriétaire du post
        if ($post->user_id != auth()->id()) {
            $postOwner = User::find($post->user_id);
            if ($postOwner) {
                $postOwner->notify(new NotificationsCommentNotification($post, $comment));
            }

            // Broadcast event
            event(new commentNotification([
                'post_id' => $post->id,
                'comment_id' => $comment->id,
                'author' => auth()->user()->name,
                'author_id' => auth()->id(),
                'content' => substr($comment->content ?? '', 0, 50),
                'post_content' => substr($post->content ?? '', 0, 50),
                'created_at' => now()->toDateTimeString(),
                'message' => auth()->user()->name . ' a commenté votre post',
                'post_owner_id' => $post->user_id,
                'state' => true
            ]));
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
        
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé avec succès'
        ]);
    }
} 