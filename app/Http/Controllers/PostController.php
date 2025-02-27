<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Hashtag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $postsCount = $user->posts()->count();
        $connectionsCount = $user->connections()->count();

        $posts = Post::with(['user.profile', 'comments.user.profile', 'comments.replies.user.profile', 'hashtags'])
                     ->withCount(['comments', 'likes'])
                     ->latest()
                     ->paginate(10);

        $trendingTags = Hashtag::selectRaw('hashtags.*, (SELECT COUNT(*) FROM hashtag_post JOIN posts ON posts.id = hashtag_post.post_id WHERE hashtag_post.hashtag_id = hashtags.id AND posts.deleted_at IS NULL) as hashtag_posts_count')
                        ->whereExists(function($query) {
                            $query->from('posts')
                                 ->join('hashtag_post', 'posts.id', '=', 'hashtag_post.post_id')
                                 ->whereRaw('hashtags.id = hashtag_post.hashtag_id')
                                 ->whereNull('posts.deleted_at');
                        })
                        ->orderBy('hashtag_posts_count', 'desc')
                        ->take(5)
                        ->get();

        return view('dashboard', compact('posts', 'trendingTags', 'user', 'postsCount', 'connectionsCount'));
    }

    public function show(Post $post)
    {
        $post->load(['user.profile', 'comments.user.profile', 'comments.replies.user.profile', 'hashtags'])
             ->loadCount(['comments', 'likes']);

        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|max:5000',
            'code_snippet' => 'nullable|string',
            'programming_language' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'video' => 'nullable|mimes:mp4,mov,avi|max:102400',
        ]);

        $post = auth()->user()->posts()->create([
            'content' => $request->content,
            'code_snippet' => $request->code_snippet,
            'programming_language' => $request->programming_language,
        ]);

        $media = [];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts/images', 'public');
            $media['images'] = [asset('storage/' . $path)];
        }

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('posts/videos', 'public');
            $media['videos'] = [asset('storage/' . $path)];
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
            'programming_language' => 'nullable|string',
            'image' => 'nullable|image|max:5120', 
            'video' => 'nullable|mimes:mp4,mov,avi|max:102400', 
        ]);

        $post->update($request->only(['content', 'code_snippet', 'programming_language']));

        $media = $post->media ?? [];

        if ($request->hasFile('image')) {
            if (isset($media['images']) && !empty($media['images'])) {
                foreach ($media['images'] as $image) {
                    \Storage::disk('public')->delete(str_replace('storage/', '', $image));
                }
            }
            $path = $request->file('image')->store('posts/images', 'public');
            $media['images'] = [asset('storage/' . $path)];
        }

        if ($request->hasFile('video')) {
            if (isset($media['videos']) && !empty($media['videos'])) {
                foreach ($media['videos'] as $video) {
                    \Storage::disk('public')->delete(str_replace('storage/', '', $video));
                }
            }
            $path = $request->file('video')->store('posts/videos', 'public');
            $media['videos'] = [asset('storage/' . $path)];
        }

        if (!empty($media)) {
            $post->media = $media;
            $post->save();
        }

        return back()->with('success', 'Post mis à jour avec succès');
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

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès');
    }

    public function updateComment(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment->update(['content' => $request->content]);

        return back()->with('success', 'Commentaire mis à jour avec succès');
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        $comment->delete();
        return back()->with('success', 'Commentaire supprimé avec succès');
    }

    public function replyToComment(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $reply = new Comment([
            'user_id' => auth()->id(),
            'post_id' => $comment->post_id,
            'parent_id' => $comment->id,
            'content' => $request->content,
        ]);

        $reply->save();

        return back()->with('success', 'Réponse ajoutée avec succès');
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