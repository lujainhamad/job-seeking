<?php

namespace App\Exceptions;

class CustomExceptionWithMessage extends BaseException
{

    protected $message;

    public function __construct($message = "Error")
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
        ], 500);
    }
}
