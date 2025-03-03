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
            $randomUserCount = min(rand(0, 5), $users->count());
            $randomUsers = $users->random($randomUserCount);

            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $post->id,
                    'likeable_type' => Post::class
                ]);

                $post->increment('likes_count');
            }
        });

        Comment::all()->each(function ($comment) use ($users) {
            $randomUserCount = min(rand(0, 3), $users->count());
            $randomUsers = $users->random($randomUserCount);

            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $comment->id,
                    'likeable_type' => Comment::class
                ]);

                $comment->increment('likes_count');
            }
        });
    }
}
