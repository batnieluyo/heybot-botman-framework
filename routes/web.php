<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Benchmark;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\CurlHttpClient;

Route::get('/', function () {
    return ['version' => '1.0.0'];
})->withoutMiddleware([
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
]);

Route::get('/benchmark', function () {
    $url = "";
    Benchmark::dd([
        'process' => fn() => Process::start([
            'bash',
            '-c',
            "curl -X POST -H 'Content-Type: application/json' -d '" .json_encode(['foo'=>'bar']) . "' $url > /dev/null 2>&1 &"
        ]),
        'curl' => fn () => exec("curl -X POST -H 'Content-Type: application/json' -d '" . json_encode(['foo'=>'bar']) . "' $url > /dev/null 2>&1 &"),
        'Guzzle' => fn () => \Illuminate\Support\Facades\Http::get($url),
        'Symfony HttpClient' => fn () => HttpClient::create(['http_version' => '2.0'])->request('GET', $url),
        'Symfony CurlHttpClient' => fn () => new CurlHttpClient([
            'buffer' => false,
            'max_redirects' => 0,
            'verify_peer' => true,
            'verify_host' => true,
        ])->request('GET',$url),
    ]);
});
