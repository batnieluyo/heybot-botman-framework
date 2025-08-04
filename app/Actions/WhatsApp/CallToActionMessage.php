<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class CallToActionMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function with(string $message, string $buttonText, string $buttonUrl, ?string $header = null, ?string $footer = null)
    {
        $this->fluent = (new Fluent)
            ->set('type', 'callToAction')
            ->set('payload.header', $header)
            ->set('payload.body', $message)
            ->set('payload.footer', $footer)
            ->set('payload.button.text', $buttonText)
            ->set('payload.button.url', $buttonUrl);

        return $this;
    }

    public function toArray(): array
    {
        if (!$this->fluent) {
            throw new \LogicException("You must call with() before toArray()");
        }

        return $this->fluent->toArray();
    }
}
