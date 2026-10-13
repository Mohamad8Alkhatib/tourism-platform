<?php

namespace App\Http\Requests\Guide;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewGuideApplicationRequest extends FormRequest
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
            'status' => ['required', Rule::in([
                'under_review', 'approved', 'rejected', 'changes_requested',
            ])],
            'review_note' => ['required_if:status,rejected,changes_requested', 'nullable', 'string', 'max:200'],
        ];
    }
}
