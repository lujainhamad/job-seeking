<?php

namespace App\Jobs;


use App\Services\Notifications\AbstractNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificationService;

    public $tries = 3;

    public $backoff = 60;

    public function __construct(AbstractNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }


    public function handle(): void
    {
        $success = $this->notificationService->send();
        if (!$success) {
            throw new \Exception('Something went wrong, failing the job.');
        }
    }
}
