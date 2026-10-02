<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TripPlanItem extends Model
{
    protected $fillable = [
        'trip_plan_id',
        'itemable_type',
        'itemable_id',
        'day_number',
        'sort_order',
        'start_time',
        'notes',
        'source',
    ];

    public function tripPlan(): BelongsTo
    {
        return $this->belongsTo(TripPlan::class);
    }

    public function itemable(): MorphTo
    {
        return $this->morphTo();
    }
}
