<?php

namespace App\Listeners;

use App\Actions\Contact\ContactAction;
use App\AutoLoaders\JourneyAutoloader;
use App\Dto\WhatsAppMessage;
use App\Events\WhatsAppNewMessage;

class WhatsAppNewMessageListener
{
    /**
     * Handle the event.
     */
    public function handle(WhatsAppNewMessage $event): void
    {
        $whatsapp = new WhatsAppMessage(request: $event->request);

        $contact = (new ContactAction)->handle(
            phone: $whatsapp->contactPhone,
            displayName: $whatsapp->contactName,
        );

        JourneyAutoloader::boot($contact->current_stage)->handle(whatsAppMessage: $whatsapp, contact: $contact);
    }
}
