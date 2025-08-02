<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequestRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required','email','max:255'],
            'password' => ['required','string']
        ];
    }
}
