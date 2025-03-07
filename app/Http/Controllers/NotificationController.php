<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get()
            ->map(function ($notification) {
                if (is_string($notification->data)) {
                    $notification->data = json_decode($notification->data, true) ?? ['message' => 'Notification'];
                }
                return $notification;
            });
        
        return response()->json($notifications);
    }

    /**
     * Mark a notification as read
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }
        
        if ($id === 'new-notification') {
            return response()->json(['success' => true]);
        }
        
        $notification = $user->notifications()->where('id', $id)->first();
        
        if (!$notification) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }
        
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }
        
        $user->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Get count of unread notifications
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['count' => 0]);
        }
        
        $count = $user->unreadNotifications->count();
        
        return response()->json(['count' => $count]);
    }
} 