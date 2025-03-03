<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['name'];
    


    public function posts()
    {
        return $this->hasMany(Post::class, 'language_id');
    }

}
