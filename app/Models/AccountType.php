<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountType extends Model
{
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const GUIDE = 'guide';
    public const OWNER = 'owner';
    public const TOURIST = 'tourist';

    protected $fillable = [
        'type',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
