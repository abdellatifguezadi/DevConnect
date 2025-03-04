<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

class CommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $commentId;
    protected $postId;
    protected $userId;
    protected $userName;
    protected $content;
    protected $notifiableId;

    /**
     * Create a new notification instance.
     */
    public function __construct($comment, $user)
    {
        // Store IDs and necessary data instead of full models
        $this->commentId = $comment->id;
        $this->postId = $comment->post_id;
        $this->userId = $user->id;
        $this->userName = $user->name;
        $this->content = substr($comment->content, 0, 100); // First 100 chars
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $this->notifiableId = $notifiable->id;
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('Your post received a new comment.')
                    ->action('View Post', url('/posts/' . $this->postId))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'comment_id' => $this->commentId,
            'post_id' => $this->postId,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'content' => $this->content,
            'type' => 'comment',
            'message' => $this->userName . ' commented on your post'
        ];
    }
    
    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'comment_id' => $this->commentId,
            'post_id' => $this->postId,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'content' => $this->content,
            'type' => 'comment',
            'message' => $this->userName . ' commented on your post',
            'time' => now()->diffForHumans()
        ]);
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        if (isset($this->notifiableId)) {
            return new PrivateChannel('App.Models.User.' . $this->notifiableId);
        }
        
        return new PrivateChannel('App.Models.User.1'); // Fallback channel that won't be used
    }
}
