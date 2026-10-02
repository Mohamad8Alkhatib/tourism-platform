<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlacePolicy
{
    public function update(User $user, Place $place): bool
    {
        return $this->isApprovedOwner($user, $place);
    }

    public function delete(User $user, Place $place): bool
    {
        return $this->isApprovedOwner($user, $place);
    }
    private function isApprovedOwner(User $user, Place $place): bool
    {
        if (! $user->owner)
            return false;

        return $place->owners()
            ->where('owner_id', $user->owner->id)
            ->wherePivot('status', 'approved')
            ->exists();
    }
}
