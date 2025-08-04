<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class InteractiveButtonsMessageWithImage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function __construct()
    {
        $this->fluent = new Fluent;
    }

    public function withButton(string $id, array $buttonText)
    {
        $sections = $this->fluent->get('payload.buttons', []);

        $sections[] = ['id' => $id, 'buttonText' => $buttonText];

        $this->fluent->set('payload.buttons', $sections);

        return $this;
    }

    public function with(string $message, string $imageUrl, ?string $footer = null)
    {
        $this->fluent
            ->set('type', 'interactiveReplyButtons')
            ->set('payload.header.type', 'image')
            ->set('payload.header.url', $imageUrl)
            ->set('payload.body', $message)
            ->set('payload.footer', $footer);

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
