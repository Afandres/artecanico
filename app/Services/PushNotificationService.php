<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PushNotificationService
{
    public function send($externalUserId, $title, $message)
    {
        $icon = url('/images/logo.png');

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://onesignal.com/api/v1/notifications', [
            'app_id' => env('ONESIGNAL_APP_ID'),
            'include_external_user_ids' => [$externalUserId],
            'target_channel' => 'push',
            'headings' => ['es' => $title, 'en' => $title],
            'contents' => ['es' => $message, 'en' => $message],
            'chrome_web_icon' => $icon,
            'small_icon' => $icon,
            'large_icon' => $icon,
        ]);

        logger()->info('ONESIGNAL RESPONSE', $response->json());

        return $response->json();
    }
}