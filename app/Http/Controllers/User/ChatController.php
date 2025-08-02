<?php

namespace App\Http\Controllers\User;

use App\Events\ChatMessageSent;
use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateChatRequest;
use App\Http\Resources\ChatResource;
use App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ChatController extends BaseCRUDController
{
        public function __construct(ChatService $service)
        {
            $this->service = $service;
            $this->resource = ChatResource::class;
            $this->createRequest = CreateChatRequest::class;

        }

        public function store(Request $request)
    {
        $request = app($this->createRequest);
        $data = $request->validated();
        if(Auth::check()){
            $data['user_id'] = Auth::id();
        }
        $data['sender_id'] = Auth::id();
        $data['sender_type'] = 'user';


        $res = $this->service->create($data);
        event(new ChatMessageSent($res)); 
        return Response::success($this->showResource($res));
    }
}
