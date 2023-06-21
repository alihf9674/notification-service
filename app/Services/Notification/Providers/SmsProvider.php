<?php

namespace App\Services\Notification\Providers;

use App\Models\User;
use App\Services\Notification\Providers\Contracts\Provider;
use GuzzleHttp\Client;

class SmsProvider implements Provider
{
    private $user;
    private $textMessage;

    public function __construct(User $user, string $textMessage)
    {
        $this->user = $user;
        $this->textMessage = $textMessage;
    }

    public function send()
    {
        $client = new Client();
        $response = $client->post(config('service.sms.uri'), $this->prepareSmsData());
        return $response->getBody();
    }

    private function prepareSmsData()
    {
        $data = array_merge(config('services.sms.auth'), [
            'op' => 'send',
            'message' => $this->textMessage,
            'to' => [$this->user->phone_number]
        ]);
        return [
            'json' => $data
        ];
    }
}
