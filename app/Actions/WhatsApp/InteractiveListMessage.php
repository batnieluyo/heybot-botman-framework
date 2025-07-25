<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class InteractiveListMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function __construct()
    {
        $this->fluent = new Fluent;
    }

    public function section(string $title, Row ...$rows)
    {
        $sections = $this->fluent->get('payload.sections', []);

        $sections[] = [
            'title' => $title,
            'rows' => collect($rows)->map(fn($row) => $row->toArray())->toArray(),
        ];

        $this->fluent->set('payload.sections', $sections);

        return $this;
    }

    public function with(?string $header = null, ?string $message = null, $buttonText = 'Ver opciones', ?string $footer = null)
    {
        $this->fluent
            ->set('type', 'interactiveList')
            ->set('payload.header', $header)
            ->set('payload.body', $message)
            ->set('payload.buttonText', $buttonText)
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
