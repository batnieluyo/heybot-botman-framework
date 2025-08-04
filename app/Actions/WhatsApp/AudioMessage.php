<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class AudioMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function with(string $fileUrl)
    {
        $this->fluent = (new Fluent)
            ->set('type', 'audio')
            ->set('payload.url', $fileUrl);

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
