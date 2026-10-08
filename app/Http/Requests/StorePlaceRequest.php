<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlaceRequest extends FormRequest
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
            'city_id' => 'required|integer|exists:cities,id',
            'name_en' => [
                'required', 'string', 'max:200',
                Rule::unique('places', 'name_en')
                    ->where(fn ($q) => $q
                    ->where('city_id', $this->input('city_id'))
                    ->where('latitude', $this->input('latitude'))
                    ->where('longitude', $this->input('longitude')))
                ->whereNull('deleted_at'),
            ],
            'name_ar' => 'nullable|string|max:200',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'opining_hours' => 'nullable|array',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'integer|exists:categories,id',
        ];
    }
}
