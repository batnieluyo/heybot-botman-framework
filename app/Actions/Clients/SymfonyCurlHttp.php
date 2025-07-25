<?php

namespace App\Actions\Clients;
use Symfony\Component\HttpClient\CurlHttpClient;

class SymfonyCurlHttp extends AbstractHttp
{
    private function __client()
    {
        return new CurlHttpClient([
            'buffer' => false,
            'max_redirects' => 0,
            'verify_peer' => true,
            'verify_host' => true,
        ]);
    }

    public function post(string $endpoint)
    {
        return $this->__client()->request('POST', $endpoint, [
            'timeout' => 30,
            'headers' => $this->headers,
            'json' => $this->payload,
        ]);
    }

    public function get(string $endpoint)
    {
        return $this->__client()->request('GET', $endpoint, [
            'timeout' => 30,
            'headers' => $this->headers,
            'json' => $this->payload,
        ]);
    }
}