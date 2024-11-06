<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Administracion\PuestosTrabajoController;

Route::controller(PuestosTrabajoController::class)->group(function () {
    Route::get('/puestos', 'index');           
    Route::get('/{id}', 'show');        
    Route::post('/addpuesto', 'create');          
    Route::put('update/{id}', 'update');       
    Route::delete('delete/{id}', 'destroy');   
});
