<?php

use App\Http\Controllers\EmpleadorController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ObservacionesController;
use App\Http\Controllers\PlanillaController;
use App\Http\Controllers\PuestosTrabajoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\TipoDocumentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//GET
Route::get('/instituciones', [InstitucionController::class, 'index']);
Route::get('/observaciones', [ObservacionesController::class, 'index']);
Route::get('puestostrabajo', [PuestosTrabajoController::class, 'index']);
Route::get('/tipodocumentos', [TipoDocumentoController::class, 'index']);
Route::get('/empleados', [EmpleadosController::class, 'index']);
Route::get('/empleado/{id}', [EmpleadosController::class, 'show']);
Route::get('/empleador', [EmpleadorController::class, 'index']);
Route::get('planilla', [PlanillaController::class, 'index']);
Route::get('planilla/{periodo}', [ReportesController::class, 'planillaPDF']);
Route::get('empleadopdf/{periodo}/{id}', [ReportesController::class, 'empleadoPDF']);
Route::get('planillaxlsx/{periodo}', [ReportesController::class, 'planillaExcel']);
Route::get('sendemail/{periodo}/{id}', [PlanillaController::class, 'sendEmail']);

//POST
Route::prefix('addpuesto')->group(function () {
    Route::post('/', [PuestosTrabajoController::class, 'create']);
});
Route::prefix('addempleado')->group(function () {
    Route::post('/', [EmpleadosController::class, 'create']);
});


//PATCH
Route::patch('updateempleado/{id}', [EmpleadosController::class, 'update']);
Route::patch('updatepuesto/{id}', [PuestosTrabajoController::class, 'update']);

//DELETE
Route::delete('deleteempleado/{id}', [EmpleadosController::class, 'destroy']);