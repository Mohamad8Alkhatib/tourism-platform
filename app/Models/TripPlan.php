<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripPlan extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
        'days_count',
        'start_date',
        'end_date',
        'budget',
        'currency_id',
        'travel_style',
        'source',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'decimal:2',
            'budget' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'trip_plan_categories');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TripPlanItem::class);
    }
}
