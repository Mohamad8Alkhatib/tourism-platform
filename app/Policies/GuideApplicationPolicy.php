<?php

namespace App\Policies;

use App\Models\GuideApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GuideApplicationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GuideApplication $guideApplication): bool
    {
        return $guideApplication->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GuideApplication $guideApplication): bool
    {
        return $guideApplication->user_id === $user->id
            && $guideApplication->status === 'changes_requested';
    }
}
