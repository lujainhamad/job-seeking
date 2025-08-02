<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required','string','max:100'],
            'email' => ['required','email','unique:companies,email'],
            'password' => ['required','string'],
            'logo' => ['sometimes'],
            'address' => ['required'],
            'file' => ['sometimes'],
        ];
    }
}
