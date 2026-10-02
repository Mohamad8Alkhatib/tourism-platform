<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourAvailability extends Model
{
    protected $fillable = [
        'tour_id',
        'start_at',
        'capacity',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime'
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
