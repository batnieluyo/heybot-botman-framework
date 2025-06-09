<?php

namespace App\Heybot;

use App\Heybot\Client\Whatsapp;
use Illuminate\Support\Facades\Log;

class Heybot
{
    protected $http;

    public function __construct()
    {
        $this->http = new Whatsapp(apiKey: config('whatsapp.api_key'));
    }

    public function toPhoneNumber($phoneNumber)
    {
        $this->http->phoneNumber($phoneNumber);

        return $this;
    }

    private function canConnectToServer()
    {
        return ! is_null(config('whatsapp.api_key'));
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    protected function __send($message)
    {
        if (! $this->canConnectToServer()) {
            Log::debug('send', $message);

            return null;
        }

        return $this->http->request([$message]);
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    protected function __bulkSend(array $messages)
    {
        if (! $this->canConnectToServer()) {
            Log::debug('bulk', $messages);

            return null;
        }

        return $this->http->request($messages);
    }
}
