<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\TextMessage;
use App\Dto\WhatsAppMessage;
use App\Heybot\Botman;
use App\Models\Contact;
use App\Options\WhatsAppMessageType;
use Carbon\Carbon;

class DefaultStage extends Botman
{
    const string GROUP = 'default';

    const string ACTION_NAME = 'default';

    public function handle(WhatsAppMessage $whatsAppMessage, Contact $contact)
    {
        $this->toPhoneNumber($contact->phone);
        $this->saveIncomeMessage(contact: $contact, request: $whatsAppMessage->request);

        // Add your awesome code 🚀

        $firstMessage = (new TextMessage)->handle(message: '¡Hola mundo!');
        $secondMessage = (new TextMessage)->allowPreviewUrl()->handle(message: '¡Hola! Visita https://google.com');

        // Recommended for only one message
        // $this->sendMessage($firstMessage);

        // Recommended if you will send many messages at once
        $this->sendManyMessages([
            $firstMessage,
            $secondMessage,
        ]);

        // Also you can validate some message type
        // if ($whatsAppMessage->messageType !== WhatsAppMessageType::TEXT) {
        // ...
        // }

        $this->saveReplyMessagesTo(contact: $contact);

        $contact->update([
            'current_group' => self::GROUP,
            'current_stage' => self::ACTION_NAME,
            'message_send_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
