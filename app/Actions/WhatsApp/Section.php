<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class Section implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function __construct(
        public readonly string $title
    ) {}

    public function withRows(Row ...$rows)
    {
        $rows = collect($rows)->map(fn($row) => $row->toArray())->toArray();
        $this->fluent = (new Fluent)->set('title', $this->title)->set('rows', $rows);

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