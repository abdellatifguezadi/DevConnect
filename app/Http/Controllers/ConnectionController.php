<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function sendRequest(User $user)
    {
        // Vérifier si une connexion existe déjà
        $existingConnection = Connection::where(function($query) use ($user) {
            $query->where('requester_id', auth()->id())
                  ->where('requested_id', $user->id);
        })->orWhere(function($query) use ($user) {
            $query->where('requester_id', $user->id)
                  ->where('requested_id', auth()->id());
        })->first();

        if ($existingConnection) {
            return back()->with('error', 'Une demande de connexion existe déjà avec cet utilisateur.');
        }

        // Créer la demande de connexion
        Connection::create([
            'requester_id' => auth()->id(),
            'requested_id' => $user->id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Demande de connexion envoyée avec succès.');
    }

    public function acceptRequest(Connection $connection)
    {
        // Vérifier si l'utilisateur est autorisé à accepter cette demande
        if ($connection->requested_id !== auth()->id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à accepter cette demande.');
        }

        $connection->update(['status' => 'accepted']);

        return back()->with('success', 'Demande de connexion acceptée.');
    }

    public function rejectRequest(Connection $connection)
    {
        // Vérifier si l'utilisateur est autorisé à refuser cette demande
        if ($connection->requested_id !== auth()->id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à refuser cette demande.');
        }

        $connection->delete();

        return back()->with('success', 'Demande de connexion refusée.');
    }

    public function cancelRequest(Connection $connection)
    {
        // Vérifier si l'utilisateur est autorisé à annuler cette demande
        if ($connection->requester_id !== auth()->id()) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à annuler cette demande.');
        }

        $connection->delete();

        return back()->with('success', 'Demande de connexion annulée.');
    }

    public function removeConnection(Connection $connection)
    {
        // Vérifier si l'utilisateur fait partie de cette connexion
        if (!in_array(auth()->id(), [$connection->requester_id, $connection->requested_id])) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette connexion.');
        }

        $connection->delete();

        return back()->with('success', 'Connexion supprimée.');
    }

    public function getPendingRequests()
    {
        $pendingRequests = Connection::where('requested_id', auth()->id())
            ->where('status', 'pending')
            ->with(['requester.profile'])
            ->get();

        return view('connections.pending', compact('pendingRequests'));
    }

    public function getAllConnections()
    {
        $connections = Connection::where(function($query) {
            $query->where('requester_id', auth()->id())
                  ->orWhere('requested_id', auth()->id());
        })
        ->where('status', 'accepted')
        ->with(['requester.profile', 'requested.profile'])
        ->get()
        ->map(function($connection) {
            // Déterminer l'autre utilisateur (pas l'utilisateur authentifié)
            return $connection->requester_id === auth()->id() 
                ? $connection->requested 
                : $connection->requester;
        });

        return view('connections.index', compact('connections'));
    }
}
