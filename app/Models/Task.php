<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'employer',
        'employer_id',
        'task_description',
        'pages',
        'rate',
        'amount',
        'status',
        'date',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'rate' => 'decimal:2',
        'pages' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    // Calculate amount automatically
    public function calculateAmount()
    {
        $this->amount = $this->pages * $this->rate;
        return $this;
    }

    // Scope for filtering by status
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for filtering by employer
    public function scopeByEmployer($query, $employer)
    {
        return $query->where('employer', $employer);
    }
}
