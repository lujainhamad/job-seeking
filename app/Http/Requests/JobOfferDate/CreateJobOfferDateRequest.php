<?php

namespace App\Http\Requests\JobOfferDate;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobOfferDateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'dates' => ['required','array'],
            'job_offer_id' => ['required','exists:jobs_offers,id'],
        ];
    }
}
