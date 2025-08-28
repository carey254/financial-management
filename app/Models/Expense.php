<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'item',
        'amount',
        'category',
        'necessary',
        'status',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope for filtering by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for necessary items
    public function scopeNecessary($query)
    {
        return $query->where('necessary', 'Yes');
    }

    // Scope for non-necessary items
    public function scopeNonNecessary($query)
    {
        return $query->where('necessary', 'No');
    }
}
