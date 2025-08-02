<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseIndexController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Skill\SkillResource;
use App\Services\SkillService;
use Illuminate\Http\Request;

class SkillController extends BaseIndexController
{
    public function __construct(SkillService $service)
    {
        $this->service = $service;
        $this->resource = SkillResource::class;
    }
}
