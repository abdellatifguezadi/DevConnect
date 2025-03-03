<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            'PHP', 'JavaScript', 'Python', 'Java', 'C#', 'C++', 
            'TypeScript', 'Ruby', 'Go', 'Swift', 'Kotlin', 'Rust'
        ];

        foreach ($languages as $language) {
            Language::firstOrCreate(['name' => $language]);
        }
    }
}