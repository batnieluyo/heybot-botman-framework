<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\Button;
use App\Actions\WhatsApp\ImageMessage;
use App\Actions\WhatsApp\InteractiveButtonsMessage;
use App\Actions\WhatsApp\InteractiveListMessage;
use App\Actions\WhatsApp\Row;
use App\Actions\WhatsApp\Section;
use App\Actions\WhatsApp\WhatsApp;
use App\Actions\WhatsApp\TextMessage;
use App\Dto\WhatsAppMessage;

class DefaultStage
{
    const string GROUP = 'default';
    const string ACTION_NAME = 'default';

    public function handle(WhatsAppMessage $whatsAppMessage)
    {
        $whatsapp = new WhatsApp(contact: $whatsAppMessage->contact);

        // Add your awesome code 🚀

        $whatsapp->add(
            (new TextMessage)->with(message: '¡Hola mundo!'),
            (new ImageMessage)->with(url: 'https://picsum.photos/200/300'),
            (new InteractiveButtonsMessage)->buttons(new Button(id: 1, buttonText: 'Button 1'), new Button(id: 2, buttonText: 'Button 1'), new Button(id: 4, buttonText: 'Button 1'))->with(message: 'hola hola'),
            (new InteractiveListMessage)
                ->section('Section 1',
                    new Row(id: '1', title: 'aa', description: 'aa'),
                    new Row(id: '2', title: 'aa', description: 'aa'),
                    new Row(id: '3', title: 'aa', description: 'aa'),
                )->section('Section 2',
                    new Row(id: '4', title: 'aa', description: 'aa'),
                    new Row(id: '5', title: 'aa', description: 'aa'),
                    new Row(id: '6', title: 'aa', description: 'aa'),
                )->with(
                    buttonText: 'Click Me'
                ),
        );

        // Also, you can validate some message type
        // if ($whatsAppMessage->messageType !== WhatsAppMessageType::TEXT) {
        // ...
        // }

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: self::GROUP,
            toStage: self::ACTION_NAME
        );
    }
}