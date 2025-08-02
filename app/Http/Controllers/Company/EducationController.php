<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseIndexController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Skill\SkillResource;
use App\Services\EducationService;
use Illuminate\Http\Request;

class EducationController extends BaseIndexController
{
   
    public function __construct(EducationService $service)
    {
        $this->service = $service;
        $this->pagination = null;
        $this->resource = SkillResource::class;

    }
}
