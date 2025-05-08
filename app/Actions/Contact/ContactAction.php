<?php

namespace App\Actions\Contact;

use App\Models\Contact;

class ContactAction
{
    public function handle($phone, $displayName)
    {
        $time = now()->format('Y-m-d H:i:s');

        $contact = Contact::firstOrCreate([
            'phone' => $phone,
        ], [
            'display_name' => $displayName,
            'current_group' => 'default',
            'current_stage' => 'default',
            'message_received_at' => $time,
            'message_send_at' => null,
        ]);

        if (! $contact->wasRecentlyCreated) {
            $contact->update([
                'message_received_at' => $time
            ]);
        }

        return $contact;
    }
}