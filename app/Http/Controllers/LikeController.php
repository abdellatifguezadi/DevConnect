<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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
            }

            // Rafraîchir le nombre de likes depuis la base de données
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