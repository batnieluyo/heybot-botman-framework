<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Benchmark;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\CurlHttpClient;

Route::get('/', function () {

    Benchmark::dd([
        'curl' => fn () => exec("curl -X POST -H 'Content-Type: application/json' -d '" . json_encode(['foo'=>'bar']) . "' https://webhook.site/6bfcff5c-95f8-4801-95fb-505ac29a89e4 > /dev/null 2>&1 &"),
        'Guzzle' => fn () => \Illuminate\Support\Facades\Http::get('https://webhook.site/6bfcff5c-95f8-4801-95fb-505ac29a89e4'),
        'Symfony HttpClient' => fn () => HttpClient::create(['http_version' => '2.0'])->request('GET','https://webhook.site/6bfcff5c-95f8-4801-95fb-505ac29a89e4'),
        'Symfony CurlHttpClient' => fn () => (new CurlHttpClient([
            'buffer' => false,
            'max_redirects' => 0,
            'verify_peer' => true,
            'verify_host' => true,
        ]))->request('GET','https://webhook.site/6bfcff5c-95f8-4801-95fb-505ac29a89e4'),
    ]);

    return ['version' => '1.0.0'];
})->withoutMiddleware([
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
]);
