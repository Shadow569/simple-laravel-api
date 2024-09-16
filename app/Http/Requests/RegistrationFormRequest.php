<?php

namespace App\Http\Requests;

class RegistrationFormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name is required',
            'name.string' => 'name must be of a text type',
            'email.required' => 'email is required',
            'email.string' => 'email must be of a text type',
            'email.unique' => 'given email is already used',
            'email.email' => 'email is not valid',
            'password.required' => 'password is required',
            'password.min' => 'password must be at least 8 character long',
            'device_name' => 'device_name is required'
        ];
    }
}
