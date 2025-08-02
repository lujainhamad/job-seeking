<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends BaseCRUDController
{
    public function __construct(UserService $service)
    {
        $this->service = $service; 
        $this->resource = UserResource::class;
    }

    public function statistics(){
        $data = $this->service->statistics();
        return Response::success($data);
    }

    public function mostWanted(){
        $data = $this->service->mostWanted();
        return Response::success($data);
    }
    public function mostPublished(){
        $data = $this->service->mostPublished();
        return Response::success($data);
    }


      public function favorites($id)
    {
        $res = $this->service->favorites($id);
        return Response::success($res);
    }
     public function unfavorites($id)
    {
        $res = $this->service->unfavorites($id);
        return Response::success($res);
    }

     public function rateCompany($id)
    {
        $data = request()->only('rating');
        $res = $this->service->rateCompany($data,$id);
        return Response::success($res);
    }
}
