<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PuestoTrabajoController;

Route::prefix('/')->controller(PuestoTrabajoController::class)->group(function () {
    Route::get('/', 'index');          
    Route::get('/{id}', 'show');               
    Route::post('/', 'store');              
    Route::put('/{id}', 'update');           
    Route::delete('/{id}', 'destroy');     
});
