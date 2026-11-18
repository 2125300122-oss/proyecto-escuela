<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AdminAuthController;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\MarcaApiController;
use App\Http\Controllers\Api\TipoApiController;
use App\Http\Controllers\Api\AdministradorApiController;
use App\Http\Controllers\Api\EmpleadoApiController;
use App\Http\Controllers\Api\PedidoApiController;

/*
|--------------------------------------------------------------------------
| RUTAS API (DESPROTEGIDAS Y ENLAZADAS AL SERVIDOR API PRINCIPAL)
|--------------------------------------------------------------------------
*/

// Rutas de login públicas (Soporta GET y POST)
Route::match(['get', 'post'], '/login', [AdminAuthController::class, 'login']);
Route::match(['get', 'post'], '/admin/login', [AdminAuthController::class, 'login']);
Route::match(['get', 'post'], '/administradores/login', [AdminAuthController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout']);
Route::match(['get', 'post'], '/admin/logout', [AdminAuthController::class, 'logout']);

// RUTAS API ADMINISTRADORES (GET, POST, PUT, DELETE)
Route::get('/administradores', [AdministradorApiController::class, 'index']);
Route::get('/administradores/{id}', [AdministradorApiController::class, 'show']);
Route::post('/administradores', [AdministradorApiController::class, 'store']);
Route::put('/administradores/{id}', [AdministradorApiController::class, 'update']);
Route::delete('/administradores/{id}', [AdministradorApiController::class, 'destroy']);

// RUTAS API PRODUCTOS (GET, POST, PUT, DELETE)
Route::get('/productos', [ProductoApiController::class, 'index'])->name('Productos.index');
Route::get('/productos/{id}', [ProductoApiController::class, 'show'])->name('Productos.show');
Route::post('/productos', [ProductoApiController::class, 'store'])->name('Productos.store');
Route::put('/productos/{id}', [ProductoApiController::class, 'update'])->name('Productos.update');
Route::delete('/productos/{id}', [ProductoApiController::class, 'destroy'])->name('Productos.destroy');

// RUTAS API CLIENTES (GET, POST, PUT, DELETE)
Route::get('/clientes', [ClienteApiController::class, 'index']);
Route::get('/clientes/{id}', [ClienteApiController::class, 'show']);
Route::post('/clientes', [ClienteApiController::class, 'store']);
Route::put('/clientes/{id}', [ClienteApiController::class, 'update']);
Route::delete('/clientes/{id}', [ClienteApiController::class, 'destroy']);

// RUTAS API MARCAS / PROVEEDORES (GET, POST, PUT, DELETE)
Route::get('/marcas', [MarcaApiController::class, 'index']);
Route::get('/marcas/{id}', [MarcaApiController::class, 'show']);
Route::post('/marcas', [MarcaApiController::class, 'store']);
Route::put('/marcas/{id}', [MarcaApiController::class, 'update']);
Route::delete('/marcas/{id}', [MarcaApiController::class, 'destroy']);

// RUTAS API CATEGORÍAS (GET, POST, PUT, DELETE)
Route::get('/categorias', [CategoriaApiController::class, 'index']);
Route::get('/categorias/{id}', [CategoriaApiController::class, 'show']);
Route::post('/categorias', [CategoriaApiController::class, 'store']);
Route::put('/categorias/{id}', [CategoriaApiController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriaApiController::class, 'destroy']);

// RUTAS API TIPOS (GET, POST, PUT, DELETE)
Route::get('/tipos', [TipoApiController::class, 'index']);
Route::get('/tipos/{id}', [TipoApiController::class, 'show']);
Route::post('/tipos', [TipoApiController::class, 'store']);
Route::put('/tipos/{id}', [TipoApiController::class, 'update']);
Route::delete('/tipos/{id}', [TipoApiController::class, 'destroy']);

// RUTAS API EMPLEADOS (GET, POST, PUT, DELETE)
Route::get('/empleados', [EmpleadoApiController::class, 'index']);
Route::get('/empleados/{id}', [EmpleadoApiController::class, 'show']);
Route::post('/empleados', [EmpleadoApiController::class, 'store']);
Route::put('/empleados/{id}', [EmpleadoApiController::class, 'update']);
Route::delete('/empleados/{id}', [EmpleadoApiController::class, 'destroy']);

// RUTAS API PEDIDOS (GET, DELETE)
Route::get('/pedidos', [PedidoApiController::class, 'index']);
Route::get('/pedidos/{id}', [PedidoApiController::class, 'show']);
Route::delete('/pedidos/{id}', [PedidoApiController::class, 'destroy']);
