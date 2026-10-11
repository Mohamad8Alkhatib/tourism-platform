<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $ar = $request->query('lang') === 'ar';

        return [
            'id' => $this->id,
            'name' => $ar ? ($this->name_ar ?: $this->name_en) : $this->name_en,
            'description' => $ar ? ($this->description_ar ?: $this->description_en) : $this->description_en,
            'location' => $this->location,
            'start_date' => $this->start_date?->toDateString(),
            'end_date' => $this->end_date?->toDateString(),
            'organizer' => $this->organizer,
            'ticket_information' => $this->ticket_information,
            'status' => $this->status,
            'city' => $this->whenLoaded('city', fn () => [
                'id' => $this->city->id,
                'name' => $ar ? ($this->city->name_ar ?: $this->city->name_en) : $this->city->name_en,
            ]),
            'category' => $this->whenLoaded('category', fn () => $this->category ? [
                'id' => $this->category->id,
                'name' => $ar ? ($this->category->name_ar ?: $this->category->name_en) : $this->category->name_en,
            ] : null),
            'images' => $this->whenLoaded('images', fn () => $this->images->map(fn ($img) => [
                'id' => $img->id,
                'url' => asset('storage/'.$img->path),
            ])),
            'creator' => $this->whenLoaded('creator', fn() => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
