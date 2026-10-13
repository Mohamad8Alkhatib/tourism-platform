<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guide extends Model
{
    protected $fillable = [
        'user_id',
        'city_id',
        'bio_en',
        'bio_ar',
        'years_experience',
        'languages',
        'verification_status',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'languages' => 'array',
            'verified_at' => 'datetime'
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
    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
