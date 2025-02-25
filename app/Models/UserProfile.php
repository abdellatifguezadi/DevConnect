<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'github_url',
        'linkedin_url',
        'website_url',
        'location',
        'avatar',
        'cover_image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 