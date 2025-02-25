<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->jobTitle(),
            'bio' => fake()->paragraph(),
            'github_url' => 'https://github.com/' . fake()->userName(),
            'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
            'website_url' => fake()->url(),
            'location' => fake()->city() . ', ' . fake()->country(),
            'avatar' => 'https://avatar.iran.liara.run/public/boy',
            'cover_image' => fake()->imageUrl(1200, 400),
        ];
    }
} 