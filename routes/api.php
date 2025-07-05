<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeRateController;

Route::get('/exchange-rates', [ExchangeRateController::class, 'index']);
Route::get('/exchange-rates/{exchangeRate}', [ExchangeRateController::class, 'show']);
