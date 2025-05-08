<?php

namespace App\AutoLoaders;

use App\Dto\WhatsAppMessage;
use App\Models\Contact;

interface JourneyStageInterface
{
    public function handle(WhatsAppMessage $whatsAppMessage, Contact $contact);
}
