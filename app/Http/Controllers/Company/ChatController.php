<?php

namespace App\Http\Controllers\Company;

use App\Events\ChatMessageSent;
use App\Http\Controllers\BaseCRUDController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateChatRequest;
use App\Http\Resources\ChatResource;
use App\Http\Resources\User\UserResource;
use App\Models\Chat;
use App\Models\User;
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
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }
        $data['sender_id'] = Auth::id();
        $data['sender_type'] = $data['receiver_type'] == 'company' ? 'user':'company';


        $res = $this->service->create($data);
        event(new ChatMessageSent($res));
        return Response::success($this->showResource($res));
    }


    public function usersChats()
    {
        $companyId = Auth::id(); 

        $users = Chat::where('sender_type', 'company')
            ->where('sender_id', $companyId)
            ->orWhere(function ($query) use ($companyId) {
                $query->where('receiver_type', 'company')
                    ->where('receiver_id', $companyId);
            })
            ->pluck('receiver_id')
            ->merge(
                Chat::where('receiver_type', 'company')
                    ->where('receiver_id', $companyId)
                    ->pluck('sender_id')
            )
            ->unique();


        $users = User::whereIn('id', $users)->get();
        return Response::success(
            UserResource::collection($users)
        );
    }
}
