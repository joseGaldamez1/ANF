<?php

use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ObservacionesController;
use App\Http\Controllers\PuestosTrabajoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//GET
Route::get('/instituciones', [InstitucionController::class, 'index']);
Route::get('/observaciones', [ObservacionesController::class, 'index']);
Route::get('puestostrabajo', [PuestosTrabajoController::class, 'index']);

//POST
Route::prefix('addpuesto')->group(function () {
    Route::post('/', [PuestosTrabajoController::class, 'create']);
});
