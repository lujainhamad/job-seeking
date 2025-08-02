<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateChatRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'message' => 'required',
            'receiver_id' => 'required',
            'receiver_type' => 'required',
        ];
    }
}
