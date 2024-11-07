<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoDocumentoController;

Route::prefix('/')->controller(TipoDocumentoController::class)->group(function () {
    Route::get('/', 'index');         
    Route::get('/{id}', 'show');       
    Route::post('/', 'store');        
    Route::put('/{id}', 'update');     
    Route::delete('/{id}', 'destroy'); 
});
