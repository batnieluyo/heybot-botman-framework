<?php

namespace App\Actions\WhatsApp;

use App\Models\Contact;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpClient\CurlHttpClient;

class WhatsApp
{
    private array $messages = [];

    public function __construct(
        private readonly Contact $contact,
        private readonly string $client = 'guzzleClient',
    ) {}

    private function nativeCurlClient(string $server, array $message)
    {
        return exec("curl -X POST -H 'Content-Type: application/json' -d '" . json_encode($message) . "' $server > /dev/null 2>&1 &");
    }

    private function curlHttpClient(string $server, array $message, string $token)
    {
        return new CurlHttpClient([
            'buffer' => false,
            'max_redirects' => 0,
            'verify_peer' => true,
            'verify_host' => true,
        ])->request('POST', $server, [
            'timeout' => 30,
            'headers' => [
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json',
                'User-Agent' => 'heybot-client-php/v1',
            ],
            'json' => $message,
        ]);
    }

    private function guzzleClient(string $server, array $message)
    {
        return Http::withToken(config('whatsapp.api_key'))
            ->timeout(30)
            ->withHeaders([
                'User-Agent' => 'heybot-client-php/v1',
                'Connection' => 'keep-alive',
                'Accept-Encoding' => 'gzip, deflate',
            ])
            ->acceptJson()
            ->asJson()
            ->post("https://api.heybot.cloud/v1/messages", $message);
    }

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

        $responses = collect($this->messages)->map(function ($message) use ($apiKey, $ts, $canConnectToServer, $phone) {
            if ($canConnectToServer) {
                $message->fluent->set('toPhoneNumber', $phone);
                $this->curlHttpClient('https://api.heybot.cloud/v1/messages', $message->toArray(), $apiKey);
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
