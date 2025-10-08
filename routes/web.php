<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

route::controller(MessageController::class)
    ->group(function() {
        Route::get('/', 'showForm')->name('home');
        Route::post('/', 'submitForm')->name('submitForm');
        Route::get('/messages', 'listMessages')->name('messages');
    });