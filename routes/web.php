<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/basket/init', [BasketController::class, 'init'])->name('basket.init');
Route::post('/basket/add', [BasketController::class, 'add'])->name('basket.add')->middleware('auth');
Route::get('/basket/total', [BasketController::class, 'total'])->name('basket.total');
