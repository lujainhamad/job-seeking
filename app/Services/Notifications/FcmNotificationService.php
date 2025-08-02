<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\DB;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FcmNotificationService extends AbstractNotificationService
{
    protected $user;
    protected $title;
    protected $body;

    public function __construct($user, $title, $body)
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
    }

    public function send()
    {
        try {

            $credentials = new ServiceAccountCredentials(
                'https://www.googleapis.com/auth/firebase.messaging',
                config('services.fcm.credentialsPath')
            );

            $authToken = $credentials->fetchAuthToken()['access_token'];

            $url = "https://fcm.googleapis.com/v1/projects/" . config('services.fcm.project_id') . "/messages:send";

            DB::beginTransaction();

            $this->user->notifications()->create([
                'title' => $this->title,
                'body' => $this->body
            ]);

            $response = Http::withToken($authToken)->post($url, [
                'message' => [
                    'token' => $this->user->fcm_token,
                    'data' => [
                        'title' => $this->title,
                        'body' => $this->body,
                    ],
                    'notification' => [
                        'title' => $this->title,
                        'body' => $this->body,
                    ],
                    'apns' => [
                        'headers' => [
                            'apns-priority' => '10',
                        ],
                        'payload' => [
                            'aps' => [
                                'content-available' => 1,
                                'badge' => 5,
                                'priority' => "high",
                            ],
                        ],
                    ],
                ],
            ]);

            if ($response['error']) {
                DB::rollBack();
                return false;
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }
}
