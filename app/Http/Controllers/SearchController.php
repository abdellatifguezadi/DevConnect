<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hashtag;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        if (empty($query) || strlen($query) < 2) {
            return response()->json(['users' => [], 'hashtags' => []]);
        }

        $hashtagQuery = $query;
        if (str_starts_with($query, '#')) {
            $hashtagQuery = substr($query, 1);
        }

        $users = User::where('name', 'like', '%' . $query . '%')
            ->with('profile')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->profile?->avatar ?? 'https://avatar.iran.liara.run/public/boy',
                    'title' => $user->profile?->title ?? 'Développeur',
                    'url' => route('profile.show', $user->id)
                ];
            });


        $hashtags = [];


        if (class_exists('App\Models\Hashtag')) {
            $hashtagResults = Hashtag::where('name', 'like', '%' . $hashtagQuery . '%')
                ->limit(5)
                ->get();

            $hashtags = $hashtagResults->map(function ($hashtag) {
                return [
                    'id' => $hashtag->id,
                    'name' => $hashtag->name,
                    'posts_count' => $hashtag->posts_count ?? $hashtag->posts()->count() ?? 0,
                    'url' => route('hashtags.show', $hashtag->name)
                ];
            });
        }

        $languages = [];

        if (class_exists('App\Models\Language')) {
            $languageResults = Language::where('name', 'like', '%' . $query . '%')
                ->limit(5)
                ->get();

            $languages = $languageResults->map(function ($language) {
                return [
                    'id' => $language->id,
                    'name' => $language->name,
                    'posts_count' => $language->posts_count ?? $language->posts()->count() ?? 0,
                    'url' => route('languages.show', $language->name)
                ];
            });
        }


        return response()->json([
            'users' => $users,
            'hashtags' => $hashtags,
            'languages' => $languages
        ]);
    }

    public function showHashtag($hashtag)
    {
  
        if (str_starts_with($hashtag, '#')) {
            $hashtag = substr($hashtag, 1);
        }

        $tag = Hashtag::where('name', $hashtag)->firstOrFail();

        $posts = $tag->posts()
            ->with(['user.profile', 'comments.user.profile', 'hashtags'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('hashtags.show', compact('tag', 'posts'));
    }

    public function showLanguage($language)
    {
        $lang = Language::where('name', $language)->firstOrFail();

        $posts = $lang->posts()
            ->with(['user.profile', 'comments.user.profile', 'hashtags'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        return view('languages.show', compact('lang', 'posts'));
    }
}
