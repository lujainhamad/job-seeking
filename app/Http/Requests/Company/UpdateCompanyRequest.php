<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'is_active' => ['required','boolean'],
            'name' => ['required','string','max:100'],
            'email' => ['required','email'],
            'password' => ['required','string'],
            'logo' => ['sometimes'],
            'address' => ['required'],
            'is_active' => ['sometimes','boolean'],
            'file' => ['sometimes'],
        ];
    }
}
