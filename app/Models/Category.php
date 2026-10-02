<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name_en',
        'name_ar',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'place_categories');
    }

    public function tripPlans(): BelongsToMany
    {
        return $this->belongsToMany(TripPlan::class, 'trip_plan_categories');
    }
}
