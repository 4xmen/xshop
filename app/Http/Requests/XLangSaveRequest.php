<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XLangSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('developer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:3','max:128'],
            'tag' => ['required','alpha_dash:','min:2','max:7'],
            'img' => ['nullable','file','mimes:svg,png,jpg,gif'],
            'emoji' => ['nullable','string']
        ];
    }
}
