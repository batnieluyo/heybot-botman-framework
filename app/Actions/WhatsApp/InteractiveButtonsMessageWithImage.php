<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class InteractiveButtonsMessageWithImage
{
    public array $buttons = [];

    public function withButton(string $id, array $buttonText)
    {
        $this->buttons[] = [
            'id' => $id,
            'buttonText' => $buttonText,
        ];

        return $this;
    }

    public function handle(string $message, string $imageUrl, ?string $footer = null)
    {
        $fluent = new Fluent;

        return $fluent
            ->set('type', 'interactiveReplyButtons')
            ->set('payload', [
                'header' => [
                    'type' => 'image',
                    'url' => $imageUrl,
                ],
                'body' => $message,
                'footer' => $footer,
                'buttons' => $this->buttons,
            ]);
    }
}
