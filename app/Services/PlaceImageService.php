<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Place;
use Illuminate\Support\Collection;

class PlaceImageService
{
    public function store(Place $place, array $files): Collection
    {
        $nextOrder = ($place->images()->max('sort_order') ?? -1) + 1;

        return collect($files)->map(function ($file) use ($place, $nextOrder) {
            $path = $file->store("places/{$place->id}", 'public');

            return $place->images()->create([
                'path' => $path,
                'sort_order' => $nextOrder++,
            ]);
        });
    }
    public function delete(Image $image): void
    {
        \Storage::disk('public')->delete($image->path);
        $image->delete();
    }
}
