<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function view(?User $user, Event $event): bool
    {
        if ($event->status === 'published') {
            return true;
        }

        return $user && ($user->id === $event->created_by || $user->can('update_events'));
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Event $event): bool
    {
        return $user->can('update_events') || $this->isEditableOwner($user, $event);
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->can('delete_events') || $this->isEditableOwner($user, $event);
    }

    private function isEditableOwner(User $user, Event $event): bool
    {
        return $user->id === $event->created_by
            && in_array($event->status, ['draft', 'changes_requested'], true);
    }
}
