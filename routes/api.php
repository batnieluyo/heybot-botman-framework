<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'throttle:api',
    'auth:sanctum',
])->as('api.')
    ->group(function ($route) {
        $route->get('/user', function (Request $request) {
            return $request->user();
        })->name('user');
    });
