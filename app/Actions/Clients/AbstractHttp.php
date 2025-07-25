<?php

namespace App\Actions\Clients;

abstract class AbstractHttp implements HttpInterface
{
    protected ?string $token = null;
    protected array $payload = [];
    protected array $headers = [
        'Accept' => 'application/json',
        'User-Agent' => 'heybot-client-php/v1',
    ];

    public function withToken(string $token): static
    {
        $this->token = $token;
        $this->headers['Authorization'] = 'Bearer ' . $this->token;
        return $this;
    }

    public function withPayload(array $payload = []): static
    {
        $this->payload = $payload;
        return $this;
    }

    abstract public function post(string $endpoint);
    abstract public function get(string $endpoint);
}