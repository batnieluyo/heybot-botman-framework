<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class InteractiveListMessage
{
    public array $sections = [];

    public function withSection(string $title, array $row)
    {
        $this->sections[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
        ];

        return $this;
    }

    public function handle(string $header, string $message, string $buttonText, ?string $footer = null)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'interactiveList')
            ->set('payload', [
                'header' => $header,
                'body' => $message,
                'footer' => $footer,
                'buttonText' => $buttonText,
                'sections' => $this->sections,
            ]);
    }
}