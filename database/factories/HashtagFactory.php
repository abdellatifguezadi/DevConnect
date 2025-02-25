<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HashtagFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->unique()->word(),
            'posts_count' => fake()->numberBetween(0, 1000),
        ];
    }
} 