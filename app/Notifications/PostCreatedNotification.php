<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PostCreatedNotification extends Notification
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
            'author' => $this->post->author,
            'title' => $this->post->title,
            'message' => 'A new post has been created by ' . $this->post->author,
        ];
    }

    // Broadcast the notification using Pusher
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'author' => $this->post->author,
            'title' => $this->post->title,
            'message' => 'A new post has been created by ' . $this->post->author,
        ]);
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Save to database and broadcast in real-time
    }
}