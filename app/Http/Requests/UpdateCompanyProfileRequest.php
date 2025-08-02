<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['sometimes','string'],
            'email' => ['sometimes'],
            'password' => ['sometimes'],
            'logo' => ['sometimes'],
            'address' => ['sometimes'],
        ];
    }
}
