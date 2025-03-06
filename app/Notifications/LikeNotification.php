<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Auth;

class LikeNotification extends Notification
{
    use Queueable;

    public $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    // Store the notification in the database
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->post->id,
            'liker_name' => Auth::user()->name,
            'liker_id' => Auth::id(),
            'post_content' => substr($this->post->content ?? '', 0, 50),
            'created_at' => now(),
            'message' => Auth::user()->name . ' a liké votre post',
        ];
    }

    // Broadcast the notification using Pusher
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->post->id,
            'liker_name' => Auth::user()->name,
            'liker_id' => Auth::id(),
            'post_content' => substr($this->post->content ?? '', 0, 50),
            'created_at' => now(),
            'message' => Auth::user()->name . ' a liké votre post',
        ]);
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Save to database and broadcast in real-time
    }
}