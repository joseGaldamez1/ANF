<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportesController;

Route::controller(ReportesController::class)->group(function () {
    Route::get('/reportes/{periodo}', 'planillaPDF');           
    Route::get('empleado/{periodo}/{id}', 'empleadoPDF');        
    Route::get('/descargar/{periodo}', 'planillaExcel');          
    Route::put('/', 'emitirPlanilla');       
    Route::delete('/{id}', 'destroy');   
});
