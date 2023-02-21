<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() and auth()->user()->hasRole('super-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => ['required', 'string','min:3', 'max:255'],
            'key' => ['required', 'string', 'alpha_dash', 'max:255', "unique:settings,key,".$this->id],
            'type' => ['required', 'string'],
            'section' => ['required', 'string', 'max:255', 'min:2'],
        ];
    }
}
