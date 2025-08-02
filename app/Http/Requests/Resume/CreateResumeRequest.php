<?php

namespace App\Http\Requests\Resume;

use Illuminate\Foundation\Http\FormRequest;

class CreateResumeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => ['required','string'],
            'about' => ['sometimes','string'],
            'main_field' => ['required'],
            'second_field' => ['sometimes'],
            'experiences' => ['required','array'],
            'experiences.*.name' => ['required','string'],
            'experiences.*.start_date' => ['required','date'],
            'experiences.*.end_date' => ['sometimes','date'],
            'experiences.*.description' => ['sometimes','string'],

            'skills' => ['required','array'],
            'skills.*.skill_id' => ['required','exists:skills,id'],

            'educations' => ['required','array'],
            'educations.*.education_id' => ['required','exists:educations,id'],

            'languages' => ['required','array'],
            'languages.*.language_id' => ['required','exists:languages,id'],

        ];
    }
}
