<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'id'                => $this->id,
            'name'              => $ar ? ($this->name_ar ?: $this->name_en) : $this->name_en,
            'description'       => $ar ? ($this->description_ar ?: $this->description_en) : $this->description_en,
            'address'           => $this->address,
            'latitude'          => $this->latitude,
            'longitude'         => $this->longitude,
            'opening_hours'     => $this->opening_hours,
            'status'            => $this->status,
            'images'            => ImageResource::collection($this->whenLoaded('images')),

            'creator' => $this->whenLoaded('creator', fn() => [
                'id'    => $this->creator->id,
                'name'  => $this->creator->name,
            ]),
            'city'   => $this->whenLoaded('city', fn () => [
                'id'    => $this->city->id,
                'name'  => $ar ? ($this->city->name_ar ?: $this->city->name_en) : $this->city->name_en,
            ]),
            'categories' => $this->whenLoaded('categories', fn () => $this->categories->map(fn ($c) => [
                'id'        => $c->id,
                'name'      => $ar ? ($c->name_ar ?: $c->name_en) : $c->name_en,
            ])
            ),
        ];
    }
}
