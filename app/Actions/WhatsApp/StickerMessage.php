<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class StickerMessage
{
    /**
     * @param string $fileUrl
     * @return Fluent
     */
    public function handle(string $fileUrl)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'sticker')
            ->set('payload.url', $fileUrl);
    }
}