<?php

namespace App\Http\Controllers\Company;

use App\Exceptions\ForbiddenUserException;
use App\Exceptions\UnAuthorizedException;
use App\Http\Controllers\BaseCRUDController;
use App\Http\Pipelines\Job\JobPipeline;
use App\Http\Requests\Job\CreateJobRequest;
use App\Http\Requests\Job\UpdateJobRequest;
use App\Http\Resources\JobResource;
use App\Http\Resources\User\UserResource;
use App\Models\Job;
use App\Models\User;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;


class JobController extends BaseCRUDController
{
    public function __construct(JobService $service)
    {
        $this->service = $service;
        $this->createRequest = CreateJobRequest::class;
        $this->updateRequest = UpdateJobRequest::class;
        $this->resource = JobResource::class;
    }
    public function update(Request $request,$model)
    {
        $companyId = auth('company')->user()->id;
        $data = app($this->updateRequest)->validated();
        if ($model->id != $companyId) {
            throw new ForbiddenUserException();
        }
        $res = $this->service->update($data, $model);
        return Response::success($this->showResource($res));
    }

    public function store(Request $request)
    {
        $request = app($this->createRequest);
        $data = $request->validated();
        if (Auth::check()) {
            $data['company_id'] = Auth::id();
        }
        $res = $this->service->create($data);
        return Response::success($this->showResource($res));
    }

    public function createInerview(Request $request)
    {
        $res = $this->service->createInerview($request->only('interview_date', 'user_id', 'job_offer_id'));
        return Response::success($res);
    }
    public function submitInterview($id)
    {
        $res = $this->service->submitInterview($id);
        return Response::success($res);
    }
    public function rejectInterview($id)
    {
        $res = $this->service->rejectInterview($id);
        return Response::success($res);
    }

    public function acceptUser($id)
    {
        $res = $this->service->acceptUser($id);
        return Response::success($res);
    }


    public function createInitialSalary(Request $request)
    {
        $res = $this->service->createInitialSalary($request->only('initial_salary', 'user_id', 'job_offer_id'));
        return Response::success($res);
    }

    public function apply($id)
    {

        $res = $this->service->apply($id, request()->only('interview_date'));
        return Response::success($res);
    }
    public function myJobs()
    {
        $res = $this->service->myJobs();
        return Response::success($this->resource::collection($res));
    }

    public function search(Request $request)
    {
        $word = $request->input('word');




        $query = Job::query(); 
        
        if($request->has('word')){ 
            $response = Http::get("https://api.datamuse.com/words?ml={$word}");
      
            if ($response->successful()) {
                $words = collect($response->json())->pluck('word')->take(10); 

                $query->where(function ($query) use ($words, $word) {
                    $query->orWhere('job_title', 'LIKE', '%' . $word . '%');
                    foreach ($words as $word) {
                        $query->orWhere('job_title', 'LIKE', '%' . $word . '%');
                    }
                });
            }
        }

        $results = JobPipeline::make(builder: $query)->get();

        return Response::success($this->resource::collection($results));
    }

    public function chooseDate(Request $request, $id)
    {
        $res = $this->service->chooseDate($request->only('date'), $id);
        return Response::success($res);
    }

    public function interviews()
    {
        $res = $this->service->interviews();
        return Response::success($res);
    }
    public function userInterviews()
    {
        $res = $this->service->userInterviews();
        return Response::success($res);
    }


    public function userById($id){
        $user = User::findOrFail($id);
        $user->load(['companyRatings','resume']);
        return Response::success(UserResource::make($user));
    }
}
