<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Broadcasting\PrivateChannel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')
            ->withPivot('years_experience')
            ->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'requested_id');
    }

    public function connections()
    {
        return $this->sentConnections()->where('status', 'accepted')
            ->union($this->receivedConnections()->where('status', 'accepted'));
    }

    // public function connectedUsers()
    // {
       
    //     $connectedIds = Connection::where(function ($query) {
    //         $query->where('requester_id', $this->id)
    //             ->orWhere('requested_id', $this->id);
    //     })
    //         ->where('status', 'accepted')
    //         ->get()
    //         ->map(function ($connection) {
    //             return $connection->requester_id === $this->id
    //                 ? $connection->requested_id
    //                 : $connection->requester_id;
    //         });


    //     $connectedIds[] = $this->id;

    //     return $connectedIds;
    // }

    // public function connectedUsersPosts()
    // {
    //     return Post::whereIn('user_id', $this->connectedUsers())
    //         ->latest();
    // }

    public function getConnectionStatus(User $otherUser)
    {
        return Connection::where(function ($query) use ($otherUser) {
            $query->where('requester_id', $this->id)
                ->where('requested_id', $otherUser->id);
        })->orWhere(function ($query) use ($otherUser) {
            $query->where('requester_id', $otherUser->id)
                ->where('requested_id', $this->id);
        })->first();
    }

    // public function isConnectedWith(User $otherUser)
    // {
    //     $connection = $this->getConnectionStatus($otherUser);
    //     return $connection && $connection->status === 'accepted';
    // }

    // public function hasPendingRequestWith(User $otherUser)
    // {
    //     $connection = $this->getConnectionStatus($otherUser);
    //     return $connection && $connection->status === 'pending';
    // }

    /**
     * Get the channels that model events should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'App.Models.User.' . $this->id;
    }
}
