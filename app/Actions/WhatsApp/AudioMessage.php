<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class AudioMessage
{
    /**
     * @param string $fileUrl
     * @return Fluent
     */
    public function handle(string $fileUrl)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'audio')
            ->set('payload.url', $fileUrl);
    }
}