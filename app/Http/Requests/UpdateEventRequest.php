<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateEventRequest extends FormRequest
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
            'category_id' => ['sometimes', 'nullable', 'integer', 'exists:categories,id'],
            'name_en' => ['sometimes', 'string', 'max:200'],
            'name_ar' => ['sometimes', 'nullable', 'string', 'max:200'],
            'description_en' => ['sometimes', 'string'],
            'description_ar' => ['sometimes', 'nullable', 'string'],
            'location' => ['sometimes', 'nullable', 'string', 'max:500'],
            'start_date' => ['sometimes', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date'],
            'organizer' => ['sometimes', 'nullable', 'string', 'max:200'],
            'ticket_information' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $event = $this->route('event');
                $start = $this->input('start_date', $event?->start_date);
                $end = $this->input('end_date', $event?->end_date);

                if ($start && $end && strtotime($end) < strtotime($start)) {
                    $validator->errors()->add('end_date', 'The end date must be on or after the start date.');
                }
            },
        ];
    }
}
