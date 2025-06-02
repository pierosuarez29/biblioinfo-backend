<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuxiliarController;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->get('/user', [AuthController::class, 'getUser']);


Route::get('/usuario/añadir/{DNI}', [AuxiliarController::class, 'añadir'])->name('añadir');

Route::get('/', function () {
    return "Hola Mundo";
});