<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class XlangSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => ['required','string','min:3','max:128'],
            'tag' => ['required','alpha_dash:','min:2','max:7'],
            'img' => ['nullable','file','mimes:svg,png,jpg,gif'],
        ];
    }
}
