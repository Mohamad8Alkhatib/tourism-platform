<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Support\Collection;

class EventImageService
{
    public function store(Event $event, array $files): Collection
    {
        $order = (int) $event->images()->max('sort_order');

        return collect($files)->map(function ($file) use ($event, &$order) {
            $path = $file->store("events/{$event->id}", 'public');

            return $event->images()->create([
                'path' => $path,
                'sort_order' => ++$order,
            ]);
        });
    }

    public function delete(Image $image): void
    {
        \Storage::disk('public')->delete($image->path);
        $image->delete();
    }
}
