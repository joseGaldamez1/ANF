<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;

Route::prefix('/')->group(function () {
    Route::post('/signin',  [AuthController::class, 'signin']);
    Route::post('/signout',  [AuthController::class, 'signout']);
});
