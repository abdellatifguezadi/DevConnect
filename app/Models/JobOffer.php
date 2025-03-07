<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'company_name',
        'location',
        'employment_type',
        'salary_min',
        'salary_max',
        'currency',
        'expiry_date',
        'status',
        'experience_level',
        'requirements',
        'benefits'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    /**
     * Get the user that posted the job offer
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active job offers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where(function($query) {
                        $query->whereNull('expiry_date')
                             ->orWhere('expiry_date', '>=', now());
                    });
    }
}
