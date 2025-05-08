<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/whatsapp/new-message', function (Request $request) {
    return $request->user();
})->name('whatsapp.new_message');
