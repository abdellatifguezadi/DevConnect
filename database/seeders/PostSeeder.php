<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Hashtag;
use App\Models\Language;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $hashtags = Hashtag::all();
        $users = User::all();
        $languageIds = Language::pluck('id')->toArray();

        foreach ($users as $user) {
            Post::factory()->count(3)->create([
                'user_id' => $user->id,
                'language_id' => !empty($languageIds) ? $languageIds[array_rand($languageIds)] : null,
            ])->each(function ($post) use ($hashtags) {
                if ($hashtags->count() > 0) {
                    $post->hashtags()->attach(
                        $hashtags->random(min(rand(1, 5), $hashtags->count()))->pluck('id')->toArray()
                    );
                }
            });
        }
    }
}
