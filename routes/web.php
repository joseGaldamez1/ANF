<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {return view('login');});

Route::get('/hash/{string}', function ($string) {return Hash::make($string);});

Route::get('/', function () {return view('auth.login');})->name('login');
Route::get('/menu', function () {return view('auth.menu');})->name('menu');
Route::get('/puestosTrabajo', function () {return view('menu.puestosTrabajo');})->name('puestosTrabajo');
Route::get('/empleados', function () {return view('menu.empleados');})->name('empleados');
Route::get('/inicio', function () {return view('menu.inicio');})->name('inicio');
Route::get('/planilla', function () {return view('menu.planilla');})->name('planilla');
Route::get('/reportes', function () {return view('menu.reportes');})->name('reportes');
Route::get('/ayuda', function () {return view('menu.ayuda');})->name('ayuda');

