<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuideApplicationResource extends JsonResource
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
            'bio' => $ar ? ($this->bio_ar ?: $this->bio_en) : $this->bio_en,
            'years_experience' => $this->years_experience,
            'languages' => $this->languages,
            'status' => $this->status,
            'review_note' => $this->review_note,
            'reviewed_at' => $this->reviewed_at,
            'city' => $this->whenLoaded('city', fn () => [
                'id' => $this->city->id,
                'name' => $ar ? ($this->city->name_ar ?: $this->city->name_en) : $this->city->name_en,
            ]),
            'applicant' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
