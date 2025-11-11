<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class InteractiveButtonsMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function __construct()
    {
        $this->fluent = new Fluent;
    }

    public function button(Button $button)
    {
        $items = $this->fluent->get('payload.buttons', []);

        $items[] = $button->toArray();

        $this->fluent->set('payload.buttons', $items);

        return $this;
    }

    public function buttons(Button ...$button)
    {
        $items = $this->fluent->get('payload.buttons', []);

        collect($button)->map(function ($button) use (&$items) {
            $items[] = $button->toArray();
        });

        $this->fluent->set('payload.buttons', $items);

        return $this;
    }

    public function with(string $message, ?string $footer = null)
    {
        $this->fluent
            ->set('type', 'interactiveReplyButtons')
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
