<?php

use App\Http\Controllers\Api\CVController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/cv-data', [CVController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);
