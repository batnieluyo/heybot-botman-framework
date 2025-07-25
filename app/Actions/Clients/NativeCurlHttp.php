<?php

namespace App\Actions\Clients;

class NativeCurlHttp extends AbstractHttp
{
    private function __client(string $endpoint, string $method)
    {
        $payload = escapeshellarg(json_encode($this->payload));
        $contentTypeHeader = "-H 'Content-Type: application/json'";
        $authHeader =  $this->token ? "-H 'Authorization: Bearer $this->token'" : '';
        $command = "curl -X $method $contentTypeHeader $authHeader -d $payload $endpoint > /dev/null 2>&1 &";
        return exec($command);
    }

    public function post(string $endpoint)
    {
        return $this->__client($endpoint, 'POST');
    }

    public function get(string $endpoint)
    {
        return $this->__client($endpoint, 'GET');
    }
}