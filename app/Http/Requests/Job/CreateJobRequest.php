<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
           
            'job_title' => ['required', 'string'],
            'salary' => ['sometimes'],
            'experience' => ['sometimes'],
            'age' => ['sometimes','integer'],
            'job_type' => ['required','in:full-time,part-time,internship'],
            'gender' => ['required','in:male,female,none'],
            'job_level' => ['required','in:junior,middle,senior'],
            'application_deadline' => ['required','date'],
            'requirements' => ['required'],
            'skills' => ['required','array'],
            'skills.*.skill_id' => ['required','exists:skills,id'],
            'languages' => ['required','array'],
            'languages.*.language_id' => ['required','exists:languages,id'],
            'education_id' => ['required','exists:educations,id'],
            'skills_weight' => ['sometimes','integer','between:1,4'],
            'education_weight' => ['sometimes','integer','between:1,4'],
            'experience_weight' => ['sometimes','integer','between:1,4'],
            'lang_weight' => ['sometimes','integer','between:1,4'],

        ];
    }
}
