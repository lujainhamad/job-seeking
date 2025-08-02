<?php

namespace App\Exceptions;


class ForbiddenUserException extends BaseException
{

    protected $message;

    public function __construct($message = "UnAuthorized")
    {
        $this->message = $message;
    }

    public function report()
    {
                
    }

    public function render()
    {
        return response()->json([
            'message' => __("custom.$this->message")
        ], 403);
    }
}
