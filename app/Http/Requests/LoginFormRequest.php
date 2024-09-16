<?php

namespace App\Http\Requests;

class LoginFormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'email is required',
            'email.email' => 'email is not valid',
            'password.required' => 'password is required',
            'device_name' => 'device_name is required'
        ];
    }
}
