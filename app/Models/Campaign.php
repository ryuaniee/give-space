<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'target_amount',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected $appends = [
        'collected_amount',
        'progress',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function getCollectedAmountAttribute()
    {
        return $this->transactions()
            ->where('status', 'verified')
            ->sum('amount');
    }

    public function getProgressAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return min(($this->collected_amount / $this->target_amount) * 100, 100);
    }
}