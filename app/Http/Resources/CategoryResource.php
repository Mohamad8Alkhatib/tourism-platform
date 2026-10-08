<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
