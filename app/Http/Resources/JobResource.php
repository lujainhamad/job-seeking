<?php

namespace App\Http\Resources;

use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Skill\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'age' => $this->age,
            'application_deadline' => $this->application_deadline,
            'job_title' => $this->job_title,
            'salary' => (int) $this->salary,
            'experience' => $this->experience,
            'education_id' => $this->education_id,
            'education' => new SkillResource($this->whenLoaded('education')),
            'job_type' => $this->job_type,
            'job_level' => $this->job_level,
            'requirements' => $this->requirements,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'languages' => SkillResource::collection($this->whenLoaded('languages')), 
            'jobOfferDates' => JobOfferDateResource::collection($this->whenLoaded('jobOfferDates')),
            'pivot' => $this->whenLoaded('pivot'),
            'gender' => $this->gender
        ];
    }
}
