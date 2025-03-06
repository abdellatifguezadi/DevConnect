<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\Language;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $postsCount = $user->posts()->count();
        $connectionsCount = $user->connections()->count();

        $posts = Post::with(['user.profile', 'comments.user.profile', 'hashtags'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            $view = view('components.posts', compact('posts'))->render();
            return response()->json([
                'html' => $view,
                'hasMorePages' => $posts->hasMorePages()
            ]);
        }

        $trendingTags = Hashtag::where('posts_count', '>', 0)
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('posts', 'trendingTags', 'user', 'postsCount', 'connectionsCount'));
    }

    /**
     * Load more posts for infinite scrolling
     */
    public function loadMorePosts(Request $request)
    {
        $posts = Post::with(['user.profile', 'comments.user.profile', 'hashtags'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        $view = view('components.posts', compact('posts'))->render();
        
        return response()->json([
            'html' => $view,
            'hasMorePages' => $posts->hasMorePages(),
            'currentPage' => $posts->currentPage(),
            'totalPages' => $posts->lastPage()
        ]);
    }

    public function show(Post $post)
    {
        $post->load(['user.profile', 'comments.user.profile', 'hashtags'])
            ->loadCount(['comments', 'likes']);

        $user = $post->user;
        $postsCount = $user->posts()->count();
        $connectionsCount = $user->connections()->count();
        $posts = collect([$post]);

        return view('posts.show', compact('post', 'user', 'postsCount', 'connectionsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:5000',
            'code_snippet' => 'nullable|string',
            'language' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
            'videos.*' => 'nullable|mimes:mp4,mov,avi|max:102400',
        ]);

        $language = Language::firstOrCreate(['name' => $request->language]);

        $post = auth()->user()->posts()->create([
            'content' => $request->content,
            'code_snippet' => $request->code_snippet,
            'language_id' => $language->id,
        ]);

        $post->languages()->attach($language->id);

        $this->handleHashtags($post);

        $media = [];


        if ($request->hasFile('images')) {
            $media['images'] = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts/images', 'public');
                $media['images'][] = asset('storage/' . $path);
            }
        }


        if ($request->hasFile('videos')) {
            $media['videos'] = [];
            foreach ($request->file('videos') as $video) {
                $path = $video->store('posts/videos', 'public');
                $media['videos'][] = asset('storage/' . $path);
            }
        }

        if (!empty($media)) {
            $post->media = $media;
            $post->save();
        }

        return back()->with('success', 'Post créé avec succès');
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        $request->validate([
            'content' => 'required|max:5000',
            'code_snippet' => 'nullable|string',
            'language' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi|max:102400',
        ]);

        $oldHashtags = $post->hashtags;
        foreach ($oldHashtags as $hashtag) {
            $hashtag->decrement('posts_count');
            if ($hashtag->posts_count <= 0) {
                $hashtag->delete();
            }
        }
        $post->hashtags()->detach();

        $media = $post->media ?? [];


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts/images', 'public');
            $media['images'] = [asset('storage/' . $imagePath)];
        }


        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('posts/videos', 'public');
            $media['videos'] = [asset('storage/' . $videoPath)];
        }

        if ($request->language) {
            $language = Language::firstOrCreate(['name' => $request->language]);
            $post->language_id = $language->id;

            $post->languages()->detach();
            $post->languages()->attach($language->id);
        }

        $post->update([
            'content' => $request->content,
            'code_snippet' => $request->code_snippet,
            'media' => $media
        ]);

        $this->handleHashtags($post);

        return back()->with('success', 'Post mis à jour avec succès');
    }

    private function handleHashtags(Post $post)
    {
        preg_match_all('/#(\w+)/', $post->content, $matches);

        if (!empty($matches[1])) {
            foreach ($matches[1] as $tag) {
                $hashtag = Hashtag::firstOrCreate(['name' => strtolower($tag)]);

                if (!$post->hashtags()->where('hashtag_id', $hashtag->id)->exists()) {
                    $post->hashtags()->attach($hashtag->id);
                    $hashtag->increment('posts_count');
                }
            }
        }
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        $post->delete();
        return back()->with('success', 'Post supprimé avec succès');
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $comment->load('user.profile');

        $html = view('components.comment', ['comment' => $comment])->render();

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'html' => $html
        ]);
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment->update(['content' => $request->content]);
        $comment->load('user.profile');

        $html = view('components.comment', ['comment' => $comment])->render();

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'html' => $html
        ]);
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commentaire supprimé avec succès'
        ]);
    }

    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            $post->decrement('likes_count');
            $message = 'Like retiré';
        } else {
            $post->likes()->create([
                'user_id' => auth()->id()
            ]);
            $post->increment('likes_count');
            $message = 'Post liké';
        }

        return back()->with('success', $message);
    }

    public function toggleCommentLike(Comment $comment)
    {
        $like = $comment->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            $comment->decrement('likes_count');
            $message = 'Like retiré';
        } else {
            $comment->likes()->create([
                'user_id' => auth()->id()
            ]);
            $comment->increment('likes_count');
            $message = 'Commentaire liké';
        }

        return back()->with('success', $message);
    }
}
