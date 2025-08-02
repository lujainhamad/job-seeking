<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'email' => ['required','email','unique:companies,email'],
            'password' => ['required','string'],
            'logo' => ['sometimes','image'],
            'address' => ['required'],
            'is_active' => ['sometimes','boolean'],
            'file' => ['sometimes'],
        ];
    }
}
