<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PageSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'subtitle' => ['nullable', 'string', 'max:2048'],
            'body' => ['required', 'string', 'min:5'],
            'status' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'icon' => ['nullable', 'string', 'min:3'],
            'parent_id' => ['nullable', 'exists:pages,id'],
            'canonical' => ['nullable', 'url', 'min:5', 'max:128'],
            'markups' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (! isValidJsonLd($value)) {
                        $fail(__(
                            'The :A field must contain a valid JSON-LD script. `<script type="application/ld+json"> VALID JSON </script>`',
                            ['A' => $attribute]
                        ));
                    }
                },
            ]
        ];
    }
}
