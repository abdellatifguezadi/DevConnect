<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        try {
            $request->validate([
                'content' => 'required|max:1000',
            ]);

            $comment = $post->comments()->create([
                'user_id' => auth()->id(),
                'content' => $request->content,
            ]);

            $comment->load('user.profile');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'comment' => $comment,
                    'html' => view('components.comment', compact('comment'))->render()
                ]);
            }

            return back()->with('success', 'Commentaire ajouté avec succès');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Erreur lors de l\'ajout du commentaire');
        }
    }

    public function update(Request $request, Comment $comment)
    {
        try {
            if ($comment->user_id !== auth()->id()) {
                throw new \Exception('Non autorisé');
            }

            $request->validate([
                'content' => 'required|max:1000',
            ]);

            $comment->update([
                'content' => $request->content
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'comment' => $comment
                ]);
            }

            return back()->with('success', 'Commentaire modifié avec succès');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Erreur lors de la modification du commentaire');
        }
    }

    public function destroy(Comment $comment)
    {
        try {
            if ($comment->user_id !== auth()->id()) {
                throw new \Exception('Non autorisé');
            }

            $comment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Commentaire supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function reply(Request $request, Comment $comment)
    {
        try {
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
            $reply->load('user.profile');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'reply' => $reply,
                    'html' => view('components.reply', compact('reply'))->render()
                ]);
            }

            return back()->with('success', 'Réponse ajoutée avec succès');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Erreur lors de l\'ajout de la réponse');
        }
    }
} 