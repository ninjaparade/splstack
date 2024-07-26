<?php

use App\Http\Controllers\CalculateController;
use App\Http\Controllers\CalculateDeleteController;
use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['inertia'])->group(function () {
    Route::get('/', CalculatorController::class)->name('calculator');
    Route::delete('/calculate/{calculation}', CalculateDeleteController::class)->name('calculate.delete');
});
Route::post('/calculate', CalculateController::class)->name('calculate');
