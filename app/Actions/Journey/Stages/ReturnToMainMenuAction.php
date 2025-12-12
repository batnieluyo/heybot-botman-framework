<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\InteractiveButtonsMessage;
use App\Actions\WhatsApp\TextMessage;
use App\Actions\WhatsApp\WhatsApp;
use App\Dto\WhatsAppMessage;
use App\Actions\WhatsApp\Button;
use App\Options\WhatsAppMessageType;

class ReturnToMainMenuAction
{
    const string GROUP = 'main_menu';
    const string ACTION_NAME = 'on.return_to_main_menu';

    public static function defaultMessage(): InteractiveButtonsMessage
    {
        return (new InteractiveButtonsMessage)
            ->buttons(
                new Button(id: 'main_menu', buttonText: 'Ir al menú'))
            ->with(message: 'Para regresar al menú, presiona el siguiente botón.');
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

        match ($option) {
            "main_menu" => self::menu($whatsapp, $whatsAppMessage),
            default => self::menu($whatsapp, $whatsAppMessage)
        };
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
