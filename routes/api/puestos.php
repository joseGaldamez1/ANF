<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Administracion\PuestosTrabajoController;

Route::controller(PuestosTrabajoController::class)->group(function () {
    Route::get('/', 'index');           
    Route::get('/{id}', 'show');        
    Route::post('/addpuesto', 'create');          
    Route::put('/{id}', 'update');       
    Route::delete('/{id}', 'destroy');   
});
