<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class RequestLocationMessage
{
    public function handle(string $body)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'requestLocation')
            ->set('payload.body', $body);
    }
}