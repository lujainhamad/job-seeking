<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProblemReportRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'job_offer_id' => ['required','exists:jobs_offers,id'],
            'description' => ['required'],

        ];
    }
}
