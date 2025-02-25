<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionFactory extends Factory
{
    public function definition()
    {
        return [
            'requester_id' => User::factory(),
            'requested_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
} 