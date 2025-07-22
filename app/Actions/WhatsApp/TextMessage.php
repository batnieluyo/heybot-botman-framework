<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class TextMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    /**
     * @param string $message
     * @param bool $withLinkPreview
     * @return self
     */
    public function with(string $message, bool $withLinkPreview = false): self
    {
        $this->fluent = (new Fluent)
            ->set('type', 'text')
            ->set('payload.body', $message)
            ->set('payload.linkPreview', $withLinkPreview);

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
