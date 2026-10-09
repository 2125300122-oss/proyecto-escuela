<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\MarcaApiController;
use App\Http\Controllers\Api\TipoApiController;

/*
|--------------------------------------------------------------------------
| RUTAS DE API RESTful - FARMACIA SALUD
|--------------------------------------------------------------------------
*/

// RUTAS API PRODUCTOS / MEDICAMENTOS
Route::get('/productos', [ProductoApiController::class, 'index']);
Route::get('/productos/{id}', [ProductoApiController::class, 'show']);
Route::post('/productos', [ProductoApiController::class, 'store']);
Route::put('/productos/{id}', [ProductoApiController::class, 'update']);
Route::delete('/productos/{id}', [ProductoApiController::class, 'destroy']);

// RUTAS API CLIENTES
Route::get('/clientes', [ClienteApiController::class, 'index']);
Route::get('/clientes/{id}', [ClienteApiController::class, 'show']);
Route::post('/clientes', [ClienteApiController::class, 'store']);
Route::put('/clientes/{id}', [ClienteApiController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteApiController::class, 'destroy']);

// RUTAS API CATEGORÍAS
Route::get('/categorias', [CategoriaApiController::class, 'index']);
Route::get('/categorias/{id}', [CategoriaApiController::class, 'show']);
Route::post('/categorias', [CategoriaApiController::class, 'store']);
Route::put('/categorias/{id}', [CategoriaApiController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaApiController::class, 'destroy']);

// RUTAS API MARCAS / LABORATORIOS
Route::get('/marcas', [MarcaApiController::class, 'index']);
Route::get('/marcas/{id}', [MarcaApiController::class, 'show']);
Route::post('/marcas', [MarcaApiController::class, 'store']);
Route::put('/marcas/{id}', [MarcaApiController::class, 'update']);
Route::delete('/marcas/{id}', [MarcaApiController::class, 'destroy']);

// RUTAS API TIPOS
Route::get('/tipos', [TipoApiController::class, 'index']);
Route::get('/tipos/{id}', [TipoApiController::class, 'show']);
Route::post('/tipos', [TipoApiController::class, 'store']);
Route::put('/tipos/{id}', [TipoApiController::class, 'update']);
Route::delete('/tipos/{id}', [TipoApiController::class, 'destroy']);
