<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSaveRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email,'.$this->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'mobile'=> ['required', 'string', 'min:10'],
            'height' => ['nullable', 'numeric'],
            'weight' => ['nullable', 'numeric'],
            'sex' => ['required', 'in:MALE,FEMALE'],
            'dob' => ['nullable', 'date'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg','max:2048'],
        ];
    }
}
