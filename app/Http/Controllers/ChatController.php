<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the chat interface
     */
    public function index()
    {
        $user = Auth::user();

        // Get all connections for the current user
        $connections = \App\Models\Connection::where(function($query) use ($user) {
                $query->where('requester_id', $user->id)
                      ->orWhere('requested_id', $user->id);
            })
            ->where('status', 'accepted')
            ->with(['requester', 'requested'])
            ->latest()
            ->get();

        // Format connections to include only the other user in each connection
        $formattedConnections = $connections->map(function($connection) use ($user) {
            if ($connection->requester_id == $user->id) {
                $connection->requester = $user;
                $connection->other_user = $connection->requested;
            } else {
                $connection->requested = $user;
                $connection->other_user = $connection->requester;
            }
            return $connection;
        });

        return view('chat', [
            'connections' => $formattedConnections
        ]);
    }


    //  Get all conversations for the authenticated user

    public function getConversations(){
        $user = Auth::user();

        // Get all users that have conversations with the current user
        $conversations = DB::table('chat_messages')
            ->join('users', function ($join) use ($user) {
                $join->on('users.id', '=', 'chat_messages.from_user_id')
                    ->where('chat_messages.to_user_id', '=', $user->id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('chat_messages.from_user_id', $user->id);
            })
            ->select('users.id', 'users.name', 'users.profile_picture', DB::raw('MAX(chat_messages.created_at) as last_message_time'))
            ->groupBy('users.id', 'users.name', 'users.profile_picture')
            ->orderBy('last_message_time', 'desc')
            ->get()
            ->unique('id');

        return response()->json($conversations);
    }

    /**
     * Get messages between the current user and another user
     */
    public function getMessages($userId){
        $currentUser = Auth::user();

        // Mark messages as read
        Chat::where('from_user_id', $userId)
            ->where('to_user_id', $currentUser->id)
            ->where('read', false)
            ->update(['read' => true]);

        // Get all messages between the two users
        $messages = Chat::where(function ($query) use ($currentUser, $userId) {
            $query->where('from_user_id', $currentUser->id)
                  ->where('to_user_id', $userId);
        })->orWhere(function ($query) use ($currentUser, $userId) {
            $query->where('from_user_id', $userId)
                  ->where('to_user_id', $currentUser->id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    /**
     * Send a new message
     */
    public function sendMessage(Request $request){


        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $currentUser = Auth::user();
        $recipientId = $request->input('recipient_id');

        $message = new Chat();
        $message->from_user_id = $currentUser->id;
        $message->to_user_id = $recipientId;
        $message->message = $request->input('message');
        $message->read = false;
        $message->save();

        // Broadcast the message to the recipient via Pusher
        broadcast(new MessageSent($currentUser, $message))->toOthers();

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    /**
     * Get unread message count
     */
    public function getUnreadCount()
    {
        $unreadCount = Chat::where('to_user_id', Auth::id())
            ->where('read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * Mark a message as read
     */
    public function markAsRead($messageId)
    {
        $message = Chat::findOrFail($messageId);

        // Make sure the authenticated user is the recipient
        if ($message->to_user_id === Auth::id()) {
            $message->update(['read' => true]);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 403);
    }
}