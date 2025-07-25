<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class ImageMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function with(string $url, ?string $message = null)
    {
        if (is_null($this->fluent)) {
            $this->fluent = new Fluent;
        }

        $this->fluent
            ->set('type', 'image')
            ->set('payload.body', $message)
            ->set('payload.url', $url);

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
