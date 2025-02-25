<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class LikeFactory extends Factory
{
    public function definition()
    {
        $likeableTypes = [
            Post::class,
            Comment::class,
        ];
        
        $type = fake()->randomElement($likeableTypes);
        $model = $type::factory()->create();

        return [
            'user_id' => User::factory(),
            'likeable_id' => $model->id,
            'likeable_type' => $type,
        ];
    }

    public function forPost(Post $post)
    {
        return $this->state(function (array $attributes) use ($post) {
            return [
                'likeable_id' => $post->id,
                'likeable_type' => Post::class,
            ];
        });
    }

    public function forComment(Comment $comment)
    {
        return $this->state(function (array $attributes) use ($comment) {
            return [
                'likeable_id' => $comment->id,
                'likeable_type' => Comment::class,
            ];
        });
    }
} 