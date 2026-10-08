<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city_id' => ['sometimes', 'integer', 'exists:cities,id'],
            'name_en' => [
                'sometimes', 'string', 'max:200',
                Rule::unique('places', 'name_en')
                    ->where(fn ($q) => $q
                        ->where('city_id', $this->input('city_id', $this->route('place')->city_id))
                        ->where('latitude', $this->input('latitude', $this->route('place')->latitude))
                        ->where('longitude', $this->input('longitude', $this->route('place')->longitude)))
                    ->whereNull('deleted_at')
                    ->ignore($this->route('place')),
            ],
            'name_ar' => ['nullable', 'string', 'max:200'],
            'description_en' => ['sometimes', 'string'],
            'description_ar' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'opening_hours' => ['nullable', 'array'],
            'category_ids' => ['nullable', 'array'],
            'category_ids.*' => ['integer', 'exists:categories,id'],
        ];
    }
}
