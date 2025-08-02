<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','string'],
            'name' => ['required','string'],
            'phone' => ['required','string'],
            'birthdate' => ['required','date'],
            'logo' => ['sometimes','image'],

        ];
    }
}
