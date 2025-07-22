<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class StickerMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    /**
     * @param string $url
     * @return $this
     */
    public function with(string $url)
    {
        $this->fluent = (new Fluent)
            ->set('type', 'sticker')
            ->set('payload.url', $url);

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
