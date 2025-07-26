<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Pelanggan\OrderController;

Route::get('/provinces', [OrderController::class, 'getProvinces']);
Route::get('/cities', [OrderController::class, 'getCities']);

