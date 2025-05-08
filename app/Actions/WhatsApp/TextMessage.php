<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class TextMessage
{
    private bool $linkPreview = false;

    public function allowPreviewUrl()
    {
        $this->linkPreview = true;
        return $this;
    }

    /**
     * @param $message
     * @return Fluent
     */
    public function handle($message)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'text')
            ->set('payload.body', $message)
            ->set('payload.linkPreview', $this->linkPreview);
    }
}