<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('years_experience')
            ->withTimestamps();
    }
}
