<?php

namespace App\Heybot\Client;

use App\Heybot\Client\Interfaces\Strategy;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class Whatsapp implements Strategy
{
    const string RESOURCE_MESSAGING = '/messages';

    const string RESOURCE_MESSAGING_TEMPLATE = '/templates';

    const string USER_AGENT = 'heybot-client-php/v1';

    private string|int $phone;

    private string $resource;

    public function __construct(
        private readonly ?string $apiKey = null,
    )
    {
    }

    /**
     * @return $this
     */
    public function phoneNumber($phoneNumber)
    {
        $this->phone = $phoneNumber;
        $this->resource = self::RESOURCE_MESSAGING;

        return $this;
    }

    /**
     * @return $this
     */
    public function template()
    {
        $this->resource = self::RESOURCE_MESSAGING_TEMPLATE;
        return $this;
    }

    /**
     * @throws ConnectionException
     */
    public function request(array $data)
    {
        $responses = [];

        foreach ($data as $content) {
            $content['toPhoneNumber'] = $this->phone;
            $response = Http::withToken(
                $this->apiKey
            )->timeout(
                30
            )->withHeaders([
                'User-Agent' => self::USER_AGENT,
                'Connection' => 'keep-alive',
                'Accept-Encoding' => 'gzip, deflate',
            ])->acceptJson()
                ->asJson()
                ->post(
                    "https://api.heybot.cloud/v1/$this->resource",
                    $content
                );

            $responses[] = $response;
        }

        return $responses;
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public function requestAsync(array $data): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $payload = array_merge(['toPhoneNumber' => $this->phone], $data);

        return Http::withToken(
            $this->apiKey
        )->timeout(
            10
        )->withHeaders([
            'User-Agent' => self::USER_AGENT,
            'Connection' => 'keep-alive',
            'Accept-Encoding' => 'gzip, deflate',
        ])->async()
            ->acceptJson()
            ->asJson()
            ->post(
                "https://api.heybot.cloud/v1/$this->resource",
                $payload
            );
    }
}
