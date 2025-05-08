<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class CallToActionMessage
{
    public function handle(string $body, $buttonText, $buttonUrl, $header = null, $footer = null)
    {
        $fluent = new Fluent;

        return $fluent
            ->set('type', 'callToAction')
            ->set('payload.header', $header)
            ->set('payload.body', $body)
            ->set('payload.footer', $footer)
            ->set('payload.button.text', $buttonText)
            ->set('payload.button.url', $buttonUrl);
    }
}
