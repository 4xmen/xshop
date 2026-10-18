<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedirectSaveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'source' => [
                'required',
                'string',
                'min:2',
                function ($attribute, $value, $fail) {
                    if (
                        ! str_starts_with($value, '/') ||
                        str_starts_with($value, '//') ||
                        preg_match('/[\r\n\\\\]/', $value)
                    ) {
                        $fail(__('The :attribute must be a relative path starting with /.'));
                    }
                },
            ],
            'destination' => ['required', 'string','min:1'],
            'expire' => ['nullable'],
        ];
    }
}
