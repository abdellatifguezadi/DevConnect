<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Post::all()->each(function ($post) {
            Comment::factory(rand(0, 10))->create([
                'post_id' => $post->id,
            ])->each(function ($comment) {
                // Créer des réponses aux commentaires
                if (fake()->boolean(30)) {
                    Comment::factory(rand(1, 3))->create([
                        'post_id' => $comment->post_id,
                        'parent_id' => $comment->id,
                    ]);
                }
            });
        });
    }
} 