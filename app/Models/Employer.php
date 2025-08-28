<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'default_rate',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'default_rate' => 'decimal:2'
    ];

    /**
     * Get the user that owns the employer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tasks for the employer.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Scope a query to only include active employers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
