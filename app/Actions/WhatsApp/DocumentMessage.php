<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class DocumentMessage
{
    /**
     * @param string $fileName
     * @param string $fileUrl
     * @return Fluent
     */
    public function handle(string $fileName, string $fileUrl)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'document')
            ->set('payload.url', $fileUrl)
            ->set('payload.filename', $fileName);
    }
}