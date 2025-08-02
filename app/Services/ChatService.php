<?php
    
namespace App\Services;

use App\Http\Pipelines\Chat\ChatPipeline;
use App\Models\Chat;


class ChatService extends BaseService {


    public function __construct()
    {
        $this->model = Chat::class;
        $this->pipeline = ChatPipeline::class;
        
    }

}