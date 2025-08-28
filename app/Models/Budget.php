<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'item',
        'budgeted_amount',
        'actual_amount',
        'month',
        'year',
        'notes'
    ];

    protected $casts = [
        'budgeted_amount' => 'decimal:2',
        'actual_amount' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Calculate difference between budget and actual
    public function getDifferenceAttribute()
    {
        return $this->budget_amount - $this->actual_amount;
    }

    // Get percentage used
    public function getPercentageUsedAttribute()
    {
        if ($this->budget_amount == 0) {
            return 0;
        }
        return ($this->actual_amount / $this->budget_amount) * 100;
    }

    // Scope for filtering by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope for filtering by month and year
    public function scopeByMonthYear($query, $month, $year)
    {
        return $query->where('month', $month)->where('year', $year);
    }
}
