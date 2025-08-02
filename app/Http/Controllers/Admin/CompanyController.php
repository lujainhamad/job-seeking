<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\User\UserResource;
use App\Models\Company;
use App\Models\Job;
use App\Models\Resume;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class CompanyController extends BaseCRUDController
{
     public function __construct(CompanyService $service)
    {
        $this->service = $service;
        $this->createRequest = CreateCompanyRequest::class;
        $this->updateRequest = UpdateCompanyRequest::class;
        $this->resource = CompanyResource::class;
    }

    public function rateUser($id)
    {
        $data = request()->only('rating');
        $res = $this->service->rateUser($data,$id);
        return Response::success($res);
    }

    public function employees()
    {
        $res = $this->service->employees();
        return Response::success(UserResource::collection($res));
    }
    public function calculateResumeCompatibility($id)
    {
        $data = request()->only('resume_id');
        $job = Job::find($id);
        $resume = Resume::find($data['resume_id']);
        $res = $this->service->calculateResumeCompatibility($job,$resume);
        return Response::success($res);
    }

    
}
