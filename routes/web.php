<?php

use App\Http\Controllers\StockCardController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('stockCard/{id}', StockCardController::class)->name('stockCard');
