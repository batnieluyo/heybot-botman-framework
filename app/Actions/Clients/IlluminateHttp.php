<?php

namespace App\Actions\Clients;

use Illuminate\Support\Facades\Http;

class IlluminateHttp extends AbstractHttp
{
    private function __client()
    {
        return Http::withToken($this->token)
            ->timeout(30)
            ->withHeaders($this->headers)
            ->acceptJson()
            ->asJson();
    }

    public function post(string $endpoint)
    {
        return $this->__client()->post($endpoint, $this->payload);
    }

    public function get(string $endpoint)
    {
        return $this->__client()->get($endpoint, $this->payload);
    }
}