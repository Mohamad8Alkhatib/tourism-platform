<?php

namespace App\Services;

use App\Models\Place;
use Illuminate\Pagination\LengthAwarePaginator;

class PlaceService
{
    public function list(): LengthAwarePaginator
    {
        return Place::with(['city', 'categories', 'images'])
            ->where('status', 'published')
            ->latest()
            ->paginate(15);
    }

    public function find(Place $place): Place
    {
        return $place->load(['city', 'categories', 'images']);
    }

    public function create(array $data): Place
    {
        return \DB::transaction(function () use ($data) {
            $categoryIds = \Arr::pull($data, 'category_ids'); // فصلنا حقل category_ids اللي بيبعتو ال flutter عن المصفوفة لأنو مالو موجود بجدول ال places,
            // ال category_ids بينضافو بجدول place_categories منشان هيك منفصل هاد الحقل عن المصفوفة اللي رح ينعمللها insert على ال places table

            $place = new Place($data);
            $place->status = 'draft';
            $place->created_by = auth()->id();
            $place->save();

            if ($categoryIds) {
                $place->categories()->sync($categoryIds);
            } // هون أضفنا مصفوفة ال categories اللي فصلناها عن المصفوفة الاساسية لجدول place_categories عن طريق علاقة categories اللي عند place

            return $place->load(['city', 'categories', 'images']);
        });
    }

    public function update(Place $place, array $data): Place
    {
        return \DB::transaction(function () use ($place, $data) {
            $categoryIds = \Arr::pull($data, 'category_ids');

            $place->update($data);

            if ($categoryIds !== null) {
                $place->categories()->sync($categoryIds);
            }

            return $place->load(['city', 'categories', 'images']);
        });
    }

    public function delete(Place $place): void
    {
        $place->delete();
    }
}
