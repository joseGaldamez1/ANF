<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanillaController;

Route::controller(PlanillaController::class)->group(function () {
    Route::get('/listar', 'index');           
    Route::get('/{periodo}', 'show');        
    Route::post('/{periodo}', 'create');          
    Route::put('/{id}', 'update');       
    Route::delete('/{id}', 'destroy');
    Route::get('/', 'emitir');    
});
