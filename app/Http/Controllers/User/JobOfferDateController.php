<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseIndexController;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobOfferDateResource;
use App\Services\JobOfferDateService;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class JobOfferDateController extends BaseIndexController
{
    public function __construct(JobOfferDateService $service)
    {
        $this->service = $service;
        $this->resource = JobOfferDateResource::class;
    }

    public function byJobOffer($id)
    {
        $res = $this->service->byJobOffer($id);
        return Response::success($res);
    }
}
