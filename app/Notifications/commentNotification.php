<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Auth;

class commentNotification extends Notification
{
    use Queueable;

    public $post;
    public $comment;

    public function __construct($post, $comment)
    {
        $this->post = $post;
        $this->comment = $comment;
    }

    // Store the notification in the database
    public function toDatabase($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
            'author' => Auth::user()->name,
            'author_id' => Auth::id(),
            'content' => substr($this->comment->content ?? '', 0, 50),
            'post_content' => substr($this->post->content ?? '', 0, 50),
            'created_at' => now(),
            'message' => Auth::user()->name . ' a commenté votre post',
            'post_owner_id' => $this->post->user_id,
        ];
    }

    // Broadcast the notification using Pusher
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id,
            'author' => Auth::user()->name,
            'author_id' => Auth::id(),
            'content' => substr($this->comment->content ?? '', 0, 50),
            'post_content' => substr($this->post->content ?? '', 0, 50),
            'created_at' => now(),
            'message' => Auth::user()->name . ' a commenté votre post',
            'post_owner_id' => $this->post->user_id,
            'state' => true
        ]);
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast']; 
}
}