<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function connections()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    public function connectedUsers()
    {
        // Récupérer les IDs des utilisateurs connectés (dans les deux sens)
        $connectedIds = Connection::where(function ($query) {
                $query->where('requester_id', $this->id)
                      ->orWhere('requested_id', $this->id);
            })
            ->where('status', 'accepted')
            ->get()
            ->map(function ($connection) {
                return $connection->requester_id === $this->id 
                    ? $connection->requested_id 
                    : $connection->requester_id;
            });

        // Ajouter l'ID de l'utilisateur actuel
        $connectedIds[] = $this->id;

        return $connectedIds;
    }

    public function connectedUsersPosts()
    {
        return Post::whereIn('user_id', $this->connectedUsers())
                   ->latest();
    }
}
