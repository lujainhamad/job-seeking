<?php

namespace App\Exceptions;


class UnVerifiedException extends BaseException
{

    protected $message;
    public $phoneVerified;
    public $emailVerified;
    public $phone;
    public $email;




    public function __construct($message = "UnVerified",$phoneVerified = false,$emailVerified = false,$phone = "",$email = "")
    {
        $this->message = $message;
        $this->phoneVerified = $phoneVerified;
        $this->emailVerified = $emailVerified;
        $this->phone = $phone;
        $this->email = $email;
    }

    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json([
            'message' => __("custom.$this->message"),
            'succes' => false,
            'phoneVerified' => $this->phoneVerified,
            'emailVerified' => $this->emailVerified,
            'phone' => $this->phone,
            'email' => $this->email
        ], 200);
    }
}