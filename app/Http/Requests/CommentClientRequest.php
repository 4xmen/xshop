<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::guard('customer')->check() || auth()->check();
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
            'name' => ['required', 'string','min:2', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'body' => ['required', 'string','max:10000','min:10'],
            'parent' => ['nullable'],
        ];
    }
}
