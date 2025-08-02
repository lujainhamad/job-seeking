<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\LoginRequestRequest;
use App\Http\Requests\Company\RegisterRequestRequest;
use App\Http\Requests\UpdateCompanyProfileRequest;
use App\Services\CompanyAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(CompanyAuthService $authService) {
        $this->authService = $authService;
    }

    public function register(RegisterRequestRequest $request)
    {
        $data = $request->validated();
        $res = $this->authService->register($data);
        return response()->success($res);
    }
    public function login(LoginRequestRequest $request)
    {
        $res = $this->authService->login($request);
        if ($res == false) return response()->error('Wrong Credentials', 401);
        else return response()->success($res);
    }

     public function getProfile()
    {
    
        $res = $this->authService->getProfile();
        return response()->success($res);
    }

     public function updateProfile(UpdateCompanyProfileRequest $request)
    {
        $data = $request->validated();
        $res = $this->authService->updateProfile($data);
        return response()->success($res);
    }

}
