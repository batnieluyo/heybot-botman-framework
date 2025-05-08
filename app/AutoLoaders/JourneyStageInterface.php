<?php

namespace App\AutoLoaders;

use App\Models\Contact;
use App\Dto\WhatsAppMessage;

interface JourneyStageInterface
{
    public function handle(WhatsAppMessage $whatsAppMessage, Contact $contact);
}