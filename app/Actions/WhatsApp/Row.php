<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class Row implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function __construct(
        public readonly string $id,
        public readonly ?string $title = null,
        public readonly ?string $description = null
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}