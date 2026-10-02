<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'tour_availability_id',
        'user_id',
        'participants',
        'total_price',
        'currency_id',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2'
        ];
    }

    public function tourAvailability(): BelongsTo
    {
        return $this->belongsTo(TourAvailability::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
