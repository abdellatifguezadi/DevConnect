<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use Illuminate\Database\Seeder;

class HashtagSeeder extends Seeder
{
    public function run()
    {
        Hashtag::factory(30)->create();
    }
} 