<?php

use App\Http\Controllers\CalculateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/calculate', CalculateController::class)->name('calculate');
