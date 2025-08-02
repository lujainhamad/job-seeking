<?php

namespace App\Http\Resources\Resume;

use App\Http\Resources\Skill\SkillResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'about' => $this->about,
            'user_id' => $this->user_id,
            'main_field' => $this->main_field,
            'second_field' => $this->second_field,
            'experiences' => $this->experiences,
            'educations' => SkillResource::collection($this->whenLoaded('educations')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'languages' => SkillResource::collection($this->whenLoaded('languages'))

        ];
    }
}
