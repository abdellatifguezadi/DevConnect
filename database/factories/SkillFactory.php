<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition()
    {
        $categories = ['language', 'framework', 'tool', 'database', 'cloud'];
        
        return [
            'name' => fake()->unique()->word(),
            'category' => fake()->randomElement($categories),
        ];
    }
} 