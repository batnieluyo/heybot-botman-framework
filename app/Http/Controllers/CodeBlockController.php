<?php

namespace App\Http\Controllers;

use App\Actions\WhatsApp\MockMessage;
use App\Options\WhatsAppMessageType;
use Illuminate\Http\Request;

class CodeBlockController extends Controller
{
    public function income($phone, $displayName)
    {
        $contact = [
            'phone' => $phone,
            'displayName' => $displayName,
        ];

        $textMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::TEXT, content: [
            'body' => '¡Hello!',
        ]);

        $imageMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::TEXT, content: [
            'url' => 'https://cdn-example.com/00000-0000-0000-0000-00000000.png',
            'mimeType' => 'application/png',
            'fileSize' => 160897,
            'body' => null,
        ]);

        $imageMessageWithMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::TEXT, content: [
            'url' => 'https://cdn-example.com/00000-0000-0000-0000-00000000.png',
            'mimeType' => 'application/png',
            'fileSize' => 160897,
            'body' => 'Has body text message',
        ]);

        $documentMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::DOCUMENT, content: [
            'url' => 'https://cdn-example.com/00000-0000-0000-0000-00000000.pdf',
            'mimeType' => 'application/pdf',
            'fileSize' => 160897,
            'body' => null,
        ]);

        $audioMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::AUDIO, content: [
            'url' => 'https://cdn-example.com/00000-0000-0000-0000-00000000.mp3',
            'mimeType' => 'audio/mpeg',
            'fileSize' => 160897,
            'body' => null,
        ]);

        $sticker = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::STICKER, content: [
            'url' => 'https://cdn-example.com/00000-0000-0000-0000-00000000.webp',
            'mimeType' => 'image/webp',
            'fileSize' => 160897,
            'body' => null,
        ]);

        $interactiveListMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::INTERACTIVE, content: [
            'id' => 'option_1',
            'listReplyTitle' => 'Sección 1',
            'listReplyDescription' => 'Opción 4',
            'type' => WhatsAppMessageType::LIST_REPLY->value,
        ]);

        $interactiveButtonReplyMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::INTERACTIVE, content: [
            'id' => 'yes',
            'buttonText' => 'Yes',
            'type' => WhatsAppMessageType::BUTTON_REPLY->value,
        ]);

        $locationMessage = (new MockMessage)->create(contact: $contact, messageType: WhatsAppMessageType::LOCATION, content: [
            'latitude' => '100.000000',
            'longitude' => '-100.000000',
        ]);

        return [
            [
                'id' => 'income-text-message',
                'title' => 'Text message',
                'description' => 'When a contact send you a text message.',
                'message_type' => WhatsAppMessageType::TEXT,
                'payload' => $textMessage,
            ],
            [
                'id' => 'income-image-message-without-body-text',
                'title' => 'Image message',
                'description' => 'When a contact send you a image message - without body-text.',
                'message_type' => WhatsAppMessageType::IMAGE,
                'payload' => $imageMessage,
            ],
            [
                'id' => 'income-image-message-with-body-text',
                'title' => 'Image message with body-text',
                'description' => 'When a contact send you a image message and contains message.',
                'message_type' => WhatsAppMessageType::IMAGE,
                'payload' => $imageMessageWithMessage,
            ],
            [
                'id' => 'income-file-message',
                'title' => 'File',
                'description' => 'When a contact send you a file.',
                'message_type' => WhatsAppMessageType::DOCUMENT,
                'payload' => $documentMessage,
            ],
            [
                'id' => 'income-audio-message',
                'title' => 'Audio message',
                'description' => 'When a contact send you a audio message.',
                'message_type' => WhatsAppMessageType::AUDIO,
                'payload' => $audioMessage,
            ],
            [
                'id' => 'income-sticker-message',
                'title' => 'Sticker message',
                'description' => 'When a contact send you a sticker.',
                'message_type' => WhatsAppMessageType::STICKER,
                'payload' => $sticker,
            ],
            [
                'id' => 'income-interactive-selected-option-message',
                'title' => 'Interactive List Message',
                'description' => 'When a contact click an option of the list.',
                'message_type' => WhatsAppMessageType::INTERACTIVE,
                'payload' => $interactiveListMessage,
            ],
            [
                'id' => 'income-interactive-button-reply-message',
                'title' => 'Interactive Reply Buttons Message',
                'description' => 'When a contact click an button as reply.',
                'message_type' => WhatsAppMessageType::INTERACTIVE,
                'payload' => $interactiveButtonReplyMessage,
            ],
            [
                'id' => 'income-location-message',
                'title' => 'Location Message',
                'description' => 'When a contact shares a location.',
                'message_type' => WhatsAppMessageType::LOCATION,
                'payload' => $locationMessage,
            ],
        ];
    }

    public function show(Request $request, $messageTypeId)
    {
        $phone = $request->get('phone', 5217772334454);
        $displayName = 'John Doe';

        $data = collect($this->income($phone, $displayName))->where('id', $messageTypeId)->first();

        return response()->json($data);
    }

    public function index(Request $request)
    {
        $phone = $request->get('phone', 5217772334454);
        $displayName = 'John Doe';

        return view('repl.whatsapp', [
            'phone' => $phone,
            'examples' => $this->income($phone, $displayName),
        ]);
    }
}
