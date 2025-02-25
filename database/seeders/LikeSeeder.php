<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run()
    {
        
        $users = User::all();
        
       
        Post::all()->each(function ($post) use ($users) {
           
            $randomUsers = $users->random(rand(0, 5));
            
            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $post->id,
                    'likeable_type' => Post::class
                ]);
                
                
                $post->increment('likes_count');
            }
        });
        
        // Liker des commentaires
        Comment::all()->each(function ($comment) use ($users) {
            // Chaque commentaire reçoit entre 0 et 3 likes aléatoires
            $randomUsers = $users->random(rand(0, 3));
            
            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $comment->id,
                    'likeable_type' => Comment::class
                ]);
                
                // Mettre à jour le compteur de likes
                $comment->increment('likes_count');
            }
        });
    }
} 