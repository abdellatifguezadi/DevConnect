<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès');
    }

    public function update(Request $request, Comment $comment)
    {
        // Vérifier si l'utilisateur est autorisé à modifier ce commentaire
        if ($comment->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return back()->with('success', 'Commentaire modifié avec succès');
    }

    public function destroy(Comment $comment)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer ce commentaire
        if ($comment->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        $comment->delete();
        return back()->with('success', 'Commentaire supprimé avec succès');
    }

    public function reply(Request $request, Comment $comment)
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

    public function updateReply(Request $request, Comment $comment, Comment $reply)
    {
        // Vérifier si l'utilisateur est autorisé à modifier cette réponse
        if ($reply->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        // Vérifier si la réponse appartient bien au commentaire parent
        if ($reply->parent_id !== $comment->id) {
            return back()->with('error', 'Réponse invalide');
        }

        $request->validate([
            'content' => 'required|max:1000',
        ]);

        $reply->update([
            'content' => $request->content
        ]);

        return back()->with('success', 'Réponse modifiée avec succès');
    }

    public function destroyReply(Comment $comment, Comment $reply)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer cette réponse
        if ($reply->user_id !== auth()->id()) {
            return back()->with('error', 'Non autorisé');
        }

        // Vérifier si la réponse appartient bien au commentaire parent
        if ($reply->parent_id !== $comment->id) {
            return back()->with('error', 'Réponse invalide');
        }

        $reply->delete();
        return back()->with('success', 'Réponse supprimée avec succès');
    }
}
