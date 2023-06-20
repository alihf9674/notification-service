<?php

namespace App\Services\Notification;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class Notification
{
    public function sendEmail(User $user, Mailable $mailable)
    {
        return Mail::to($user)->send($mailable);
    }

    public function sendSms(User $user, string $message)
    {
        $client = new Client();
        $response = $client->post(config('service.sms.uri'), $this->prepareSmsData($user, $message));
        return $response->getBody();
    }

    private function prepareSmsData(User $user, string $message)
    {
        $data = array_merge(config('services.sms.auth'), [
            'op' => 'send',
            'message' => $message,
            'to' => [$user->phone_number]
        ]);
        return [
            'json' => $data
        ];
    }
}
