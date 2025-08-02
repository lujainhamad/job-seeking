<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class BaseIndexController extends Controller
{
    protected $service;
    protected $resource;
    protected $pagination = null;

    public function index()
    {

        $res = $this->handleIndexResult($this->service->getAll());
        return Response::success($res);
    }

    public function show($model)
    {
        $res = $this->showResource($this->service->getOne($model));
        return Response::success($res);
    }

    protected function showResource($data){
        return $this->resource ? $this->resource::make($data) : $data;
    }

    protected function indexResource($data){
        return $this->resource ? $this->resource::collection($data) : $data;
    }



    public function handleIndexResult($query)
    {
        $result = [];
        if ($this->pagination) {
            $data = $query->paginate($this->pagination);
            $result['pagesCount'] = collect($data)['last_page'];
            $result['data'] = $this->indexResource($data);
        } else {
            $data = $query->get();
            $result['data'] = $this->indexResource($data);
        }
        return $result;
    }

    public function paginate($query,$resource = null,$pagination = 10)
    {
        $result = [];
        $data = $query->paginate($pagination);
        $result['pagesCount'] = collect($data)['last_page'];
        $result['data'] = $resource ? $resource::collection($data) : $data;
        return $result;
    }
}
