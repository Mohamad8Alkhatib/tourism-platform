<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return Event::query()
            ->where('status', 'published')
            ->with(['city', 'category', 'images', 'creator'])
            ->orderBy('start_date')
            ->paginate($perPage);
    }

    public function create(array $data): Event
    {
        $data['status'] = 'draft';
        $data['created_by'] = auth()->id();

        return Event::create($data)
            ->load(['city', 'category', 'images', 'creator']);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);

        return $event->load(['city', 'category', 'images', 'creator']);
    }

    public function delete(Event $event): void
    {
        $event->delete(); // Soft delete
    }
}
