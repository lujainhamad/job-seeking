<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequestRequest;
use App\Services\AdminAuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AdminAuthService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequestRequest $request)
    {
        $res = $this->authService->login($request);
        if ($res == false) return response()->error('Wrong Credentials', 401);
        else return response()->success($res);
    }

}
