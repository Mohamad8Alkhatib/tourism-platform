<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Place extends Model
{
    protected $fillable = [
        'city_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'status'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'place_categories');
    }

    public function owners(): BelongsToMany
    {
        return $this->belongsToMany(Owner::class, 'place_owners')
            ->withPivot(['status', 'verified_by', 'verified_at'])
            ->withTimestamps();
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
