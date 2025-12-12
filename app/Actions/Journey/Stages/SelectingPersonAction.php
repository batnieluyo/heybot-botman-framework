<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\InteractiveButtonsMessage;
use App\Actions\WhatsApp\TextMessage;
use App\Actions\WhatsApp\WhatsApp;
use App\Dto\WhatsAppMessage;
use App\Actions\WhatsApp\Button;
use App\Options\WhatsAppMessageType;

class SelectingPersonAction
{
    const string GROUP = 'aggression_test';
    const string ACTION_NAME = 'on.selecting_person';

    public static function defaultMessage(): InteractiveButtonsMessage
    {
        $message = <<<message
        Este test tiene 10 preguntas sobre situaciones que pueden ocurrir en una relación.
        Al final sabrás tu nivel dentro del Violentómetro:
        Nivel 1 💛 Amarillo
        Nivel 2 🧡 Naranja
        Nivel 3 ❤️ Rojo

        Pero 🔒 antes de comenzar…¿Este test lo estás haciendo *para ti o para alguien más*?
        A veces, quien vive violencia necesita usar el teléfono de alguien de confianza para sentirse más segura.
        message;

        return (new InteractiveButtonsMessage)
            ->buttons(
                new Button(id: 'for_me', buttonText: 'Para mí'),
                new Button(id: 'someone_else', buttonText: 'Alguien más'),
            )
            ->with(message: $message);
    }

    public function handle(WhatsAppMessage $whatsAppMessage)
    {
        $whatsapp = new WhatsApp(contact: $whatsAppMessage->contact);

        if ($whatsAppMessage->messageType !== WhatsAppMessageType::INTERACTIVE) {
            $whatsapp->add(
                (new TextMessage)->with(message: 'Parece que elegiste una opción incorrecta. Por favor sigue las instrucciones del siguiente mensaje.'),
                self::defaultMessage()
            );

            $whatsapp->send();

            $whatsAppMessage->contact->move(
                toGroup: self::GROUP,
                toStage: self::ACTION_NAME
            );

            return;
        }

        $option = $whatsAppMessage->getClickedButtonValue();

        // TODO: Action based on selected person type
    }

    public static function menu(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $whatsapp->add(
            MainMenuStage::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: MainMenuStage::GROUP,
            toStage: MainMenuStage::ACTION_NAME
        );
    }
}
