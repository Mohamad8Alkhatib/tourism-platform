<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'country_id',
        'name_en',
        'name_ar',
        'latitude',
        'longitude'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'admin_cities', 'city_id', 'admin_user_id');
    }
}
