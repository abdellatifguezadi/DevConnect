<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(50)
            ->has(UserProfile::factory(), 'profile')
            ->create()
            ->each(function ($user) {
                // Créer des connexions entre utilisateurs
                $otherUsers = User::where('id', '!=', $user->id)
                    ->inRandomOrder()
                    ->limit(rand(5, 15))
                    ->get();

                foreach ($otherUsers as $otherUser) {
                    $user->connections()->create([
                        'requested_id' => $otherUser->id,
                        'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
                    ]);
                }
            });
    }
} 