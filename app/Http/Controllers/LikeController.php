<?php

namespace App\Http\Controllers;

use App\Events\LikeNotification;
use App\Models\Post;
use App\Models\User;
use App\Notifications\LikeNotification as NotificationsLikeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function togglePostLike(Request $request, Post $post)
    {
        try {
            $like = $post->likes()->where('user_id', auth()->id())->first();
            $isLiked = false;

            if ($like) {
                $like->delete();
                $post->decrement('likes_count');
            } else {
                $post->likes()->create([
                    'user_id' => auth()->id()
                ]);
                $post->increment('likes_count');
                $isLiked = true;

                if ($post->user_id != Auth::id()) {
                    $postOwner = User::find($post->user_id);
                    if ($postOwner) {
                        $postOwner->notify(new NotificationsLikeNotification($post));
                    }
                    // Broadcast event
                    event(new LikeNotification([
                        'author' => auth()->user()->name,
                        'title' => substr($post->content ?? 'Post', 0, 50),
                        'message' => auth()->user()->name . ' a liké un post',
                        'post_owner_id' => $post->user->id
                    ]));
                }
            }

            $post->refresh();

            return response()->json([
                'success' => true,
                'likes_count' => $post->likes_count,
                'isLiked' => $isLiked,
                'message' => $isLiked ? 'Post liké' : 'Like retiré'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
