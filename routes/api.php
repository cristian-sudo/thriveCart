<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;

Route::post('/basket/init', [BasketController::class, 'init']);
Route::post('/basket/add', [BasketController::class, 'add']);
Route::get('/basket/total', [BasketController::class, 'total']);
