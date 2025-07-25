<?php

namespace App\Actions\WhatsApp;

use App\Actions\Clients\AbstractHttp;
use App\Models\Contact;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Str;

class WhatsApp
{
    private array $messages = [];

    public function __construct(
        private readonly Contact $contact,
        private readonly AbstractHttp $client = new \App\Actions\Clients\SymfonyCurlHttp,
    ) {}

    public function add(MessageInterface ...$messages): void
    {
        foreach ($messages as $message) {
            $this->messages[] = $message;
        }
    }

    public function send()
    {
        $ts = Carbon::now()->timestamp;

        $apiKey = config('whatsapp.api_key');
        $canConnectToServer = !is_null($apiKey);
        $phone = $this->contact->phone;

        $client = new \App\Actions\Clients\ClientHttp($this->client);

        $http = $client->http->withToken($apiKey);

        $responses = collect($this->messages)->map(function ($message) use ($http, $apiKey, $ts, $canConnectToServer, $phone) {

            if ($canConnectToServer) {
                $message->fluent->set('toPhoneNumber', $phone);
                $http->withPayload($message->toArray())->post("https://api.heybot.cloud/v1/messages");
            }

            $object = [
                'timestamp' => $ts,
                'event' => 'MESSAGE',
                'contact' => [
                    'phone' => $phone,
                    'displayName' => null,
                ],
                'object' => [
                    'type' => $message->fluent->get('type'),
                    'id' => null,
                ],
                'payload' => $message->fluent->get('payload'),
            ];

            return [
                'ulid' => Str::ulid()->toString(),
                'contact_id' => $this->contact->id,
                'direction' => 'outbound',
                'payload_type' => 'message',
                'payload' => json_encode($object),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        });

        Message::insert($responses->toArray());
    }
}
