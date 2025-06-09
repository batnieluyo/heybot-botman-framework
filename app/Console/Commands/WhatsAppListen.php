<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Ratchet\Client\Connector;
use React\EventLoop\Loop;

class WhatsAppListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen whatsapp messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token = config('whatsapp.api_key');
        $server = config('whatsapp.server');
        $forwardTo = config('whatsapp.forwardTo');

        $data = Http::withToken($token)->get("$server/account");

        if (!$data->successful()) {
            $this->error('Api token is invalid');
            return;
        }

        $content = $data->collect();
        $channel = $content->get("channel");

        $websocket = config('whatsapp.ws');

        $this->info("🔗 Connecting to *WhatsApp* and forwarding to $forwardTo");

        $loop = Loop::get();
        $connector = new Connector($loop);

        $http = new Client();
        $connector($websocket, [], [])->then(
            function ($conn) use ($channel, $token, $forwardTo, $http, $server) {

                $conn->on('message', function ($msg) use ($server, $conn, $channel, $token, $forwardTo, $http) {

                    $data = json_decode($msg, true);

                    if (($data['event'] ?? '') === 'pusher:connection_established') {
                        $payload = json_decode($data['data'], true);
                        $socketId = $payload['socket_id'] ?? null;

                        if (!$socketId) {
                            $this->error('❌ No Socket ID in connection_established');
                            return;
                        }

                        $response = Http::withToken($token)->post(
                            "$server/broadcasting/auth", [
                            'socket_id' => $socketId,
                            'channel_name' => $channel['room'],
                        ]);

                        if ($response->failed()) {
                            $this->error("❌ Auth failed: " . $response->body());
                            return;
                        }

                        $authData = $response->collect();

                        $this->info("✅  Listening WhatsApp Messages");

                        // Step 3: Send subscription request
                        $subscribe = [
                            'event' => 'pusher:subscribe',
                            'data' => [
                                'channel' => $channel['room'],
                                'auth' => $authData->get('auth'),
                                'channel_data' => $authData->get('channel_data'),
                            ]
                        ];

                        $conn->send(json_encode($subscribe));
                    }

                    if (($data['event'] ?? '') === 'message') {
                        try {
                            $payload = json_decode($data['data'], true);
                            $start = microtime(true);

                            $response = $http->post($forwardTo, ['headers' => [
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ], 'json' => $payload]);

                            $end = microtime(true);
                            $durationMs = round(($end - $start) * 1000, 2);

                            $rows = [[
                                $durationMs,
                                $response->getStatusCode(),
                                $data['data']
                            ]];

                            $this->table(
                                ['Request time (ms)', 'HTTP Status', 'Payload'],
                                $rows
                            );
                        } catch (\Exception $e) {
                            $this->error("❌ Error: " . $e->getMessage());
                        }
                    }
                });

                $conn->on('close', function ($code = null, $reason = null) {
                    $this->error("🔌 Connection closed: $code $reason");
                });
            },
            function (\Exception $e) {
                $this->error("❌ Connection error: " . $e->getMessage());
            }
        );

        $loop->run();
    }
}
