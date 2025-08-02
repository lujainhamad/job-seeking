<?php

namespace App\Http\Resources\Skill;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return ['name' => $this->name,'id' => $this->id];
    }
}
