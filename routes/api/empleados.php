<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;

Route::prefix('/')->controller(EmpleadosController::class)->group(function () {
    Route::get('/', 'index');          
    Route::get('/{id}', 'show');               
    Route::post('/', 'create');              
    Route::put('/{id}', 'update');           
    Route::delete('/{id}', 'destroy');     
});
