<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Connection;
use App\Models\User;

class ConnectionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $connectionId;
    protected $userId;
    protected $userName;
    protected $notifiableId;

    /**
     * Create a new notification instance.
     */
    public function __construct($connection, $user)
    {
        // Store IDs and necessary data instead of full models
        $this->connectionId = $connection->id;
        $this->userId = $user->id;
        $this->userName = $user->name;
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
                    ->line('You have a new connection request.')
                    ->action('View Profile', url('/profile/' . $this->userId))
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
            'connection_id' => $this->connectionId,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'type' => 'connection',
            'message' => $this->userName . ' sent you a connection request'
        ];
    }
    
    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'connection_id' => $this->connectionId,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'type' => 'connection',
            'message' => $this->userName . ' sent you a connection request',
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
