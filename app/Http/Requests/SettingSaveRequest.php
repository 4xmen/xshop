<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingSaveRequest extends FormRequest
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
            'title' => ['required', 'string','min:3', 'max:255'],
            'key' => ['required', 'string', 'alpha_dash', 'max:255', "unique:settings,key,".$this->id],
            'type' => ['required', 'string'],
            'section' => ['required', 'string', 'max:255', 'min:2'],
            'size' => ['required','integer','min:1','max:12']
        ];
    }
}
