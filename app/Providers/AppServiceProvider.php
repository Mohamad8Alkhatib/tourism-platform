<?php

namespace App\Providers;

use App\Models\AccountType;
use App\Models\Event;
use App\Models\Guide;
use App\Models\Permission;
use App\Models\Place;
use App\Models\Review;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'place' => Place::class,
            'event' => Event::class,
            'tour' => Tour::class,
            'guide' => Guide::class,
            'review' => Review::class,
            'user' => User::class,
        ]);

        \Gate::before(function ($user, string $ability) {
            // Super Admin: صلاحية كاملة دائما
            if ($user->accountType->type === AccountType::SUPER_ADMIN)
                return true;

            if (Permission::where('type', $ability)->exists()) {
                return $user->roles
                    ->flatMap(fn($role) => $role->permissions)
                    ->pluck('type')
                    ->contains($ability);
            }

            return null;
        });
    }
}
