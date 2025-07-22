<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class RequestLocationMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    /**
     * @param string $message
     * @return $this
     */
    public function with(string $message)
    {
        $this->fluent = (new Fluent)
            ->set('type', 'requestLocation')
            ->set('payload.body', $message);

        return $this;
    }

    public function toArray(): array
    {
        if (!$this->fluent) {
            throw new \LogicException("You must call handle() before toArray()");
        }

        return $this->fluent->toArray();
    }
}
