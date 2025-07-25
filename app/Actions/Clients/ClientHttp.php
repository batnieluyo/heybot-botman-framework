<?php

namespace App\Actions\Clients;

class ClientHttp
{
    public function __construct(
        public HttpInterface $http
    ) {}
}