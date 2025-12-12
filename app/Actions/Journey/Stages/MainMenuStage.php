<?php

namespace App\Actions\Journey\Stages;

use App\Actions\WhatsApp\ImageMessage;
use App\Actions\WhatsApp\InteractiveListMessage;
use App\Actions\WhatsApp\Row;
use App\Actions\WhatsApp\TextMessage;
use App\Actions\WhatsApp\WhatsApp;
use App\Dto\WhatsAppMessage;
use App\Options\WhatsAppMessageType;

class MainMenuStage
{
    const string GROUP = 'main_menu';
    const string ACTION_NAME = 'on.main_menu';

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
            default => self::optionOne($whatsapp, $whatsAppMessage)
        };
    }

    public static function optionOne(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        ¿Sabías que el Violentómetro te ayuda a reconocer desde las violencias más sutiles hasta las más graves?
        *Identificarlas te ayuda a protegerte y pedir apoyo a tiempo.*
        Sus colores —amarillo, naranja y rojo— muestran el nivel de peligro y cómo la violencia puede ir escalando. 💛🧡❤️

        Estos son algunos tipos de violencia:
        🧠 Psicológica
        ✋ Física
        🚫 Sexual
        💸 Económica / Patrimonial
        📱 Digital
        🤰 Obstétrica
        🏛️ Institucional
        ⚰️ Feminicida
        message;

        $whatsapp->add(
            (new ImageMessage)->with(
                url: 'https://picsum.photos/200/300',
                message: $message
            ),
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
        $whatsapp->add(
            SelectingPersonAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: SelectingPersonAction::GROUP,
            toStage: SelectingPersonAction::ACTION_NAME
        );
    }

    public static function optionThree(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        Si corres peligro, *llama de inmediato al 📞: 911*
        Llegará ayuda rápida para protegerte.

        *Línea Bienestar para las Mujeres 079 opción 1.*
        Está disponible 24/7 y te brinda:
        🧠 Apoyo emocional
        ⚖️ Asesoría legal
        🔗 Canalización a otras instituciones
        👉 *Llamar ahora 📞: 079*

        Dar el primer paso puede ser difícil, pero no estás sola. 💜
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
        $whatsapp->add(
            AggressionTypesMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: AggressionTypesMenuAction::GROUP,
            toStage: AggressionTypesMenuAction::ACTION_NAME
        );
    }

    public static function optionFive(WhatsApp $whatsapp, WhatsAppMessage $whatsAppMessage)
    {
        $message = <<<message
        🏠 *Los Centros LIBRE* son lugares seguros para las mujeres, donde puedes sentirte escuchada y apoyada.
        *Todos los servicios son gratuitos y confidenciales.*
        Aquí encontrarás:

        ⚖️ Asesoría legal. Aquí te ayudarán a saber qué hacer y a dónde acudir ante una situación legal o de violencia.
        🧠 Asesoría psicológica y social.
        👩‍👧 Espacios seguros para mujeres en situación de violencia.
        🎨 Talleres de empoderamiento y bienestar.
        💪 Fortalecimiento de la autonomía física, económica y política.
        🤝 Redes de apoyo y vínculos comunitarios.

        *Frente a la violencia, no estás sola. Morelos está en alerta por ti.* 💜

        📍 Mira la imagen para conocer el Centro LIBRE más cercano a ti.
        message;

        $whatsapp->add(
            (new ImageMessage)->with(
                url: 'https://picsum.photos/200/300',
                message: $message
            ),
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
        ¿Te sientes en riesgo o en peligro en un espacio público?
        *Código Violeta* 💜 es una red de apoyo que brinda atención inmediata a mujeres, niñas y adolescentes.

        ¿Qué puedes hacer?
        1. Busca un establecimiento público o privado con el distintivo Código Violeta.
        2. Acércate con confianza: el personal está capacitado para ayudarte.
        3. El personal contactará a los servicios de emergencia de forma segura y rápida.

        *Juntas nos cuidamos.* 💪💜
        message;

        $whatsapp->add(
            (new ImageMessage)->with(
                url: 'https://picsum.photos/200/300',
                message: $message
            ),
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
        ✨ Mira estos consejos para vivir libre de violencia.
        message;

        $whatsapp->add(
            (new ImageMessage)->with(
                url: 'https://picsum.photos/200/300',
                message: $message
            ),
            ReturnToMainMenuAction::defaultMessage()
        );

        $whatsapp->send();

        $whatsAppMessage->contact->move(
            toGroup: ReturnToMainMenuAction::GROUP,
            toStage: ReturnToMainMenuAction::ACTION_NAME
        );
    }
}
