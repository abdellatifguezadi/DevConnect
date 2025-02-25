<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition()
    {
        $programmingLanguages = ['PHP', 'JavaScript', 'Python', 'Java', 'C#', 'Ruby'];
        
        return [
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(3, true),
            'code_snippet' => fake()->boolean(70) ? fake()->text() : null,
            'programming_language' => fake()->boolean(70) ? fake()->randomElement($programmingLanguages) : null,
            'media' => fake()->boolean(30) ? json_encode([
                'images' => [fake()->imageUrl()],
                'videos' => []
            ]) : null,
            'likes_count' => fake()->numberBetween(0, 100),
            'comments_count' => fake()->numberBetween(0, 50),
            'shares_count' => fake()->numberBetween(0, 20),
        ];
    }
} 