<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(3)
            ->has(UserProfile::factory(), 'profile')
            ->create()
            ->each(function ($user) {
                
                $otherUsers = User::where('id', '!=', $user->id)
                    ->inRandomOrder()
                    ->limit(rand(1, 3))
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