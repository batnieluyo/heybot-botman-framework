<?php

namespace App\Options;

enum WhatsAppMessageType: string
{
    case TEXT = 'text';
    case REACTION = 'reaction';
    case STICKER = 'sticker';
    case VIDEO = 'video';
    case DOCUMENT = 'document';
    case IMAGE = 'image';
    case CONTACT = 'contacts';
    case LOCATION = 'location';
    case INTERACTIVE = 'interactive';
    case AUDIO = 'audio';
    case LIST_REPLY = 'listReply';
    case BUTTON_REPLY = 'buttonReply';
}