<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespondProblemReport extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'response' => ['required','string'],
        ];
    }
}
