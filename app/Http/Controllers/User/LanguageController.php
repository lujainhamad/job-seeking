<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseIndexController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Language\LanhuageResource;
use App\Services\LanguageService;
use Illuminate\Http\Request;

class LanguageController extends BaseIndexController
{
     public function __construct(LanguageService $service)
    {
        $this->service = $service;
        $this->resource = LanhuageResource::class;
    }
}
