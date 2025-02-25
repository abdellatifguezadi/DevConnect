<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Hashtag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $hashtags = Hashtag::all();

        Post::factory(10)->create()->each(function ($post) use ($hashtags) {
           
            $post->hashtags()->attach(
                $hashtags->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
} 