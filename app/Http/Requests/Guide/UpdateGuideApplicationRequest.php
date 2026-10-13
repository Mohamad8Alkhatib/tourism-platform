<?php

namespace App\Http\Requests\Guide;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGuideApplicationRequest extends FormRequest
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
            'bio_en' => ['sometimes', 'string', 'max:2000'],
            'bio_ar' => ['nullable', 'string', 'max:2000'],
            'years_experience' => ['sometimes', 'integer', 'min:0', 'max:60'],
            'languages' => ['sometimes', 'array', 'min:1'],
            'languages.*' => ['string', 'distinct', Rule::in(config('languages.allowed'))],
            'verification_document' => ['sometimes', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }
}
