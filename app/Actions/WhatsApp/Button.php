<?php

namespace App\Actions\WhatsApp;

class Button implements MessageInterface
{
    public function __construct(
        public readonly string $id,
        public readonly string $buttonText,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'buttonText' => $this->buttonText
        ];
    }
}