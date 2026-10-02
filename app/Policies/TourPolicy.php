<?php

namespace App\Policies;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TourPolicy
{
    public function update(User $user, Tour $tour): bool
    {
        return $tour->guide()->user_id === $user->id;
    }

    public function delete(User $user, Tour $tour): bool
    {
        return $tour->guide()->user_id === $user->id;
    }
}
