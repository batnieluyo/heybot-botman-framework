<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\InteractiveListMessage;
use App\Actions\WhatsApp\Row;
use App\Actions\WhatsApp\WhatsApp;
use App\Actions\WhatsApp\TextMessage;
use App\Dto\WhatsAppMessage;

class DefaultStage
{
    const string GROUP = 'default';
    const string ACTION_NAME = 'default';

    public static function defaultMessage(): InteractiveListMessage
    {
        $message = <<<message
        ¿Cómo puedo ayudarte hoy?
        message;

        return (new InteractiveListMessage)
            ->section('Elige una opción',
                new Row(id: '1', title: 'Señales de violencia', description: 'Conoce los tipos de violencia de acuerdo al violentómetro'),
                new Row(id: '2', title: 'Test', description: 'Descubre si sufres violencia y su nivel en el violentómetro'),
                new Row(id: '3', title: 'Líneas de ayuda', description: 'Contacta líneas de emergencia y asistencia inmediata'),
                new Row(id: '4', title: '¿Dónde acudir?', description: 'Orientación sobre dónde acudir según tu situación'),
                new Row(id: '5', title: 'Centros LIBRE', description: 'Espacios seguros con apoyo para mujeres y niñas'),
                new Row(id: '6', title: 'Código violeta', description: 'Establecimientos que te apoyan si te sientes en riesgo.'),
                new Row(id: '7', title: 'Prevención y consejos', description: 'Tips para vivir libre de violencia.'),
            )->with(
                message: $message,
                buttonText: 'Selecciona'
            );
    }

    public function handle(WhatsAppMessage $whatsAppMessage)
    {
        $whatsapp = new WhatsApp(contact: $whatsAppMessage->contact);

        $firstMessage = <<<message
        *¡Hola!* 🌸 Este es tu espacio seguro para informarte y recibir apoyo si estás viviendo alguna situación de violencia.
        Aquí encontrarás opciones que pueden ayudarte a sentirte protegida y acompañada.
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $firstMessage),
            MainMenuStage::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: MainMenuStage::GROUP,
            toStage: MainMenuStage::ACTION_NAME
        );
    }
}
