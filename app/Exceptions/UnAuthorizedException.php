<?php

namespace App\Exceptions;

class UnAuthorizedException extends BaseException
{
    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json([
            'message' => __("custom.UnAuthorized")
        ], 401);
    }
}
