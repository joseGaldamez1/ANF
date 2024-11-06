<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;

Route::controller(EmpleadosController::class)->group(function () {
    Route::get('/empleados', 'index');           
    Route::get('/{id}', 'show');        
    Route::post('/addempleado', 'create');          
    Route::put('update/{id}', 'update');       
    Route::delete('delete/{id}', 'destroy');   
});
