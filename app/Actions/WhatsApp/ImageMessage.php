<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class ImageMessage
{
    private ?string $message = null;

    public function withMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $fileUrl
     * @return Fluent
     */
    public function handle(string $fileUrl)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'image')
            ->set('payload.url', $fileUrl)
            ->set('payload.body', $this->message);
    }
}