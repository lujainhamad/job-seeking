<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobOfferDate\CreateJobOfferDateRequest;
use App\Http\Resources\JobOfferDateResource;
use App\Services\JobOfferDateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class JobOfferDateController extends BaseCRUDController
{
      public function __construct(JobOfferDateService $service)
    {
        $this->service = $service;
        $this->createRequest = CreateJobOfferDateRequest::class;
        $this->resource = JobOfferDateResource::class;
    }

    public function store(Request $request)
    {
        $request = app($this->createRequest);
        $data = $request->validated();
        if(Auth::check()){
            $data['user_id'] = Auth::id();
        }
        $res = $this->service->create($data);
        return Response::success($res);
    }

}
