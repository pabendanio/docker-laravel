<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MessageController::class, 'showForm']);
Route::post('/', [MessageController::class, 'submitForm']);
Route::get('/messages', [MessageController::class, 'listMessages']);