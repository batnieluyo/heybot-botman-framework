<?php

namespace App\Http\Controllers\Webhook;

use App\Events\WhatsAppNewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsAppWebhook;
use Illuminate\Support\Facades\Event;

class WhatsAppController extends Controller
{
    public function store(WhatsAppWebhook $request)
    {
        Event::dispatch(new WhatsAppNewMessage(request: $request->toArray()));

        return response()->noContent(200);
    }
}
