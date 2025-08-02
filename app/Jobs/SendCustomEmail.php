<?php

namespace App\Jobs;

use App\Mail\AbstractMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendCustomEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $mail;


    public function __construct($email, AbstractMail $mail)
    {
        $this->email = $email;
        $this->mail = $mail;
    }


    public function handle(): void
    {
        Mail::to($this->email)->send($this->mail);
    }
}
