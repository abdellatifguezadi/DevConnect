<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        // Get a random language ID or default to null
        $languageId = Language::inRandomOrder()->first()?->id;

        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(3, true),
            'code_snippet' => fake()->boolean(70) ? fake()->text() : null,
            'media' => fake()->boolean(30) ? json_encode([
                'images' => [fake()->imageUrl()],
                'videos' => []
            ]) : null,
            'likes_count' => fake()->numberBetween(0, 100),
            'comments_count' => fake()->numberBetween(0, 50),
            'shares_count' => fake()->numberBetween(0, 20),
            'language_id' => $languageId,
        ];
    }
}
