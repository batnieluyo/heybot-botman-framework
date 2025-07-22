<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class Button implements MessageInterface
{
    public ?Fluent $fluent = null;

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