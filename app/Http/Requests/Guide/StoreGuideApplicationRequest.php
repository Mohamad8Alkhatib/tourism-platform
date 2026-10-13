<?php

namespace App\Http\Requests\Guide;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGuideApplicationRequest extends FormRequest
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
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'bio_en' => ['required', 'string', 'max:2000'],
            'bio_ar' => ['nullable', 'string', 'max:2000'],
            'years_experience' => ['required', 'integer', 'min:0', 'max:60'],
            'languages' => ['required', 'array', 'min:1'],
            'languages.*' => ['string', 'distinct', Rule::in(config('languages.allowed'))],
            'verification_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }
}
