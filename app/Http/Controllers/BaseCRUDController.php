<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BaseCRUDController extends BaseIndexController
{
    protected $createRequest;
    protected $updateRequest;


    public function store(Request $request)
    {
        $request = app($this->createRequest);
        $data = $request->validated();
        if(Auth::check()){
            $data['user_id'] = Auth::id();
        }
        $res = $this->service->create($data);
        return Response::success($this->showResource($res));
    }

    public function update(Request $request,$model)
    {
        $data = app($this->updateRequest)->validated();
        $res = $this->service->update($data, $model);
        return Response::success($this->showResource($res));
    }

    public function destroy($model)
    {
        $res = $this->service->delete($model);
        return Response::success($res);
    }
}
