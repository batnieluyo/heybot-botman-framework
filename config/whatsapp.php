<?php

return [
    'api_key' => env('WHATSAPP_API_KEY'),
    'server' => env('WHATSAPP_SERVER', 'https://api.heybot.cloud/v1'),
    'forwardTo' => env('WHATSAPP_FORWARD_TO', 'http://127.0.0.1:8000/webhook/whatsapp/new-message'),
    'ws' => env('WHATSAPP_WS'),
];
