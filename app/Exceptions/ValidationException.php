<?php

namespace App\Exceptions;



class ValidationException extends BaseException
{

    protected $message;
    
    public function __construct($message = "Error In Input")
    {
        $this->message = $message;
    }

    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json([
            $this->message
        ], 422);
    }
}
