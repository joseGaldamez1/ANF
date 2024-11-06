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

Route::get('/', function () {return view('welcome');});

Route::get('/hash/{string}', function ($string) {return Hash::make($string);});

Route::get('/login', function () {return view('auth.login');})->name('login');
Route::get('/menu', function () {return view('auth.menu');})->name('menu');

