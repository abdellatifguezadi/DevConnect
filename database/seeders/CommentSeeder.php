<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::factory()->count(5)->create([
            'user_id' => User::inRandomOrder()->first()->id,
            'post_id' => Post::inRandomOrder()->first()->id,
            'content' => fake()->paragraph(),
        ]);
    }
} 