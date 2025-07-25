<?php

namespace App\Actions\Clients;

interface HttpInterface
{
    public function withToken(string $token): static;

    public function withPayload(array $payload = []): static;

    public function post(string $endpoint);

    public function get(string $endpoint);
}