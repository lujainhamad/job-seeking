<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'company_id' => ['sometimes', 'exists:companies,id'],
            'job_title' => ['sometimes', 'string'],
            'salary' => ['sometimes'],
            'experience' => ['sometimes'],
            'age' => ['sometimes','integer'],
            'job_type' => ['sometimes','in:full-time,part-time,internship'],
            'gender' => ['sometimes','in:male,female'],
            'job_level' => ['sometimes','in:junior,middle,senior'],
            'application_deadline' => ['sometimes','date'],
            'requirements' => ['sometimes'],
            'skills' => ['sometimes','array'],
            'skills.*.skill_id' => ['sometimes','exists:skills'],
            'education_id' => ['sometimes','exists:educations'],
        ];
    }
}
