<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['version' => "1.0.0"];
})->withoutMiddleware([
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class
]);