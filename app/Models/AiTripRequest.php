<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiTripRequest extends Model
{
    protected $fillable = [
        'user_id',
        'trip_plan_id',
        'input',
        'result',
        'status',
        'error_message',
        'retry_count',
    ];

    protected function casts(): array
    {
        return [
            'input' => 'array',
            'result' => 'array'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tripPlan(): BelongsTo
    {
        return $this->belongsTo(TripPlan::class);
    }
}
