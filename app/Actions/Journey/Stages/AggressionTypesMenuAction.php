<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\InteractiveListMessage;
use App\Actions\WhatsApp\Row;
use App\Actions\WhatsApp\TextMessage;
use App\Actions\WhatsApp\WhatsApp;
use App\Dto\WhatsAppMessage;
use App\Options\WhatsAppMessageType;

class AggressionTypesMenuAction
{
    const string GROUP = 'aggression_types';
    const string ACTION_NAME = 'on.aggression_type';

    public static function defaultMessage(): InteractiveListMessage
    {
        $message = <<<message
        ¡No estás sola! 💜 Ante a la violencia es importante saber dónde acudir y denunciar. Elige el tipo de violencia que estás viviendo o sobre el que quieres más información.

        message;

        return (new InteractiveListMessage)
            ->section('Elige una opción',
                new Row(id: '1', title: 'Violencia psicológica', description: ''),
                new Row(id: '2', title: 'Violencia laboral', description: ''),
                new Row(id: '3', title: 'Violencia económica', description: ''),
                new Row(id: '4', title: 'Violencia simbólica', description: ''),
                new Row(id: '5', title: 'Violencia física', description: ''),
                new Row(id: '6', title: 'Violencia sexual', description: ''),
                new Row(id: '7', title: 'Violencia obstétrica', description: ''),
                new Row(id: '8', title: 'Regresar', description: ''),
            )->with(
                message: $message,
                buttonText: 'Selecciona'
            );
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
            "1" => self::optionOne($whatsapp, $whatsAppMessage),
            "2" => self::optionTwo($whatsapp, $whatsAppMessage),
            "3" => self::optionThree($whatsapp, $whatsAppMessage),
            "4" => self::optionFour($whatsapp, $whatsAppMessage),
            "5" => self::optionFive($whatsapp, $whatsAppMessage),
            "6" => self::optionSix($whatsapp, $whatsAppMessage),
            "7" => self::optionSeven($whatsapp, $whatsAppMessage),
            "8" => self::optionEight($whatsapp, $whatsAppMessage),
            default => self::optionEight($whatsapp, $whatsAppMessage)
        };
    }

    public static function optionOne(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        *Acude a:*

        📞 *Llama al 911 o al 079 (opción 1)* en caso de emergencia.

        ⚖️ *Centro LIBRE*: asesoría jurídica y apoyo emocional.
        Los primeros auxilios jurídicos te orientan sobre qué hacer y dónde acudir antes de ir con un abogado o autoridad.
        🕗 Horario: 8:00 a.m. – 5:00 p.m.

        🏢 *Fiscalía General del Estado de Morelos*
        Áreas de Atención Temprana en:
        - *Cuernavaca-* Av. Emiliano Zapata #803, Bellavista, 62140 Cuernavaca, Mor.
        - *Temixco-* Blvd. Apatlaco #165, Centro, 62590 Temixco, Mor.
        ⏰ Atención las 24 horas, todos los días.

        🏢 *Centro de Justicia para Mujeres (CJUM)*: Av. José María Morelos #70, Col. Chipitlán, 62060 Cuernavaca, Mor.
        🕗 Horario: 8:00 a.m. – 8:00 p.m.
        📞 Número: 777 318 8753

        *Si deseas denunciar, recuerda llevar tu INE y relatar los hechos.*
        *Es muy importante que cuentes con una red de apoyo que te acompañe durante el proceso.* ❤️‍🩹
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionTwo(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        *Acude a:*
        *Tribunal Estatal de Conciliación y Arbitraje de Morelos.*
        📍Calle Francisco Leyva #5, Colonia Centro, Cuernavaca, Morelos, CP 62000
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionThree(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        *Acude a:*

        🏢 *Fiscalía General del Estado de Morelos*
        Áreas de Atención Temprana en:
        - *Cuernavaca-* Av. Emiliano Zapata #803, Bellavista, 62140 Cuernavaca, Mor.
        - *Temixco-* Blvd. Apatlaco #165, Centro, 62590 Temixco, Mor.
        ⏰ Atención las 24 horas, todos los días.

        🏢 *Centro de Justicia para Mujeres (CJUM):*
        Av. José María Morelos #70, Col. Chipitlán, 62060 Cuernavaca, Mor.
        🕗 Horario: 8:00 a.m. – 8:00 p.m.
        📞 Número: 777 318 8753
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionFour(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        *Acude a:*

        *Si proviene del núcleo familiar:*
        🏢 *Centro de Justicia para Mujeres (CJUM)*
        📍 Av. José María Morelos #70, Col. Chipitlán, 62060 Cuernavaca, Mor.
        🕗 Horario: 8:00 a.m. – 8:00 p.m.
        📞 Número: 777 318 8753

        *Si proviene de escuela, trabajo, amistades o superiores:*
        🏢 *Fiscalía General del Estado de Morelos-* Áreas de Atención Temprana en:
        - Cuernavaca: Av. Emiliano Zapata #803, Bellavista, 62140 Cuernavaca, Mor.
        - Temixco: Blvd. Apatlaco #165, Centro, 62590 Temixco, Mor.
        ⏰ Atención las 24 horas, todos los días.
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionFive(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        *Acude a:*

        📞 *Llama al 911 o 079 (opción 1).*

        🏢 *Fiscalía General del Estado de Morelos*
        Áreas de Atención Temprana en:
        - Cuernavaca: Av. Emiliano Zapata #803, Bellavista, 62140 Cuernavaca, Mor.
        - Temixco: Blvd. Apatlaco #165, Centro, 62590 Temixco, Mor.
        ⏰ Atención las 24 horas, todos los días.

        🏢 *Centro de Justicia para Mujeres (CJUM)*
        Av. José María Morelos #70, Col. Chipitlán, 62060 Cuernavaca, Mor.
        🕗 Horario: 8:00 a.m. – 8:00 p.m.
        📞 Número: 777 318 8753

        🏠 *Centro Creativería Social A.C.*
        Ofrecen refugio y acompañamiento para mujeres e hijos.
        📞 Llama a: 735 152 6683 / 735 152 6678
        ⏰ Atención las 24 horas.
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionSix(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        *Acude a:*
        Busca apoyo en tu red cercana.

        📞 *Llama al 911 o 079 (opción 1).*

        🏢 *Fiscalía General del Estado de Morelos-* Áreas de Atención Temprana en:
        - Cuernavaca: Av. Emiliano Zapata #803, Bellavista, 62140 Cuernavaca, Mor.
        - Temixco: Blvd. Apatlaco #165, Centro, 62590 Temixco, Mor.
        ⏰ Atención las 24 horas, todos los días.
        *Para presentar tu denuncia:*
        *Si eres menor de edad*, debes ir acompañada de una persona adulta de confianza.
        *Si eres mayor de edad*, recuerda llevar tu INE y relatar los hechos.
        Es muy importante que cuentes con una red de apoyo que te acompañe durante el proceso. ❤️‍🩹

        También puedes contactar al *Consultorio Verde del Centro Creativería Social A.C.*
        ⏰ Atención 24 horas.
        📞 735 152 6683 / 735 152 6678
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionSeven(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        Acude a:
        *Comisión Estatal de Arbitraje Médico (COESAMOR)*
        📍Calle Nueva Navarra #10, Col. Jardines de Reforma, Cuernavaca.
        📞 777 316 6488
        message;

        $whatsapp->add(
            (new TextMessage)->with(message: $message),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }

    public static function optionEight(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
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
