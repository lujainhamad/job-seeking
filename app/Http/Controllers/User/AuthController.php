<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\User\LoginRequestRequest;
use App\Http\Requests\User\RegisterRequestRequest;
use App\Models\Job;
use App\Models\Resume;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(RegisterRequestRequest $request)
    {
        $data = $request->validated();
        $res = $this->authService->register($data);
        return response()->success($res);
    }
     public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        $res = $this->authService->updateProfile($data);
        return response()->success($res);
    }
    public function getProfile()
    {
        
        $res = $this->authService->getProfile();
        return response()->success($res);
    }
    public function login(LoginRequestRequest $request)
    {
        $res = $this->authService->login($request);
        if ($res == false) return response()->error('Wrong Credentials', 401);
        else return response()->success($res);
    }

    public function calculateResumeCompatibility($id)
    {
        $data = request()->only('resume_id');
        $job = Job::find($id);
        $resume = Resume::find($data['resume_id']);
        $res = $this->authService->calculateResumeCompatibility($job,$resume);
        return Response::success($res);
    }

   
}
