<?php

namespace App\Actions\WhatsApp;

use App\Options\WhatsAppMessageType;
use Carbon\Carbon;
use Illuminate\Support\Fluent;

class MockMessage
{
    private function generateWamid()
    {
        $timestamp = time(); // current timestamp
        $randomBytes = random_bytes(32); // 32 random bytes

        // Combine timestamp and random bytes
        $payload = pack('N', $timestamp).$randomBytes;

        // Base64 encode
        $base64 = base64_encode($payload);

        // Prefix with "wamid."
        return 'wamid.'.$base64;
    }

    /**
     * @return Fluent
     */
    public function create(array $contact, WhatsAppMessageType $messageType, array $content)
    {
        return (new Fluent)
            ->set('timestamp', Carbon::now()->timestamp)
            ->set('event', 'MESSAGE')
            ->set('contact.phone', $contact['phone'])
            ->set('contact.displayName', $contact['displayName'])
            ->set('object', [
                'type' => $messageType->value,
                'id' => $this->generateWamid(),
            ])
            ->set('payload', $content);
    }
}
