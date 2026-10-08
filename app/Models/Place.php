<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'city_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'address',
        'latitude',
        'longitude',
        'opining_hours',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'opining_hours' => 'array',
            'is_featured' => 'boolean'
        ];
    }

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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('sort_order');
    }
}
