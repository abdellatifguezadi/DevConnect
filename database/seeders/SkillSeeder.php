<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $skills = Skill::factory(20)->create();

        User::all()->each(function ($user) use ($skills) {
            $user->skills()->attach(
                $skills->random(rand(3, 8))->pluck('id')->toArray(),
                ['years_experience' => rand(1, 10)]
            );
        });
    }
} 