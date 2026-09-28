<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/inicio', 'layouts/app');

// RUTAS ADMINISTRADORES
Route::get('/administradores/listado', [AdministradorController::class, 'listar']);
Route::get('/administradores/formulario', [AdministradorController::class, 'vistaFormulario']);
Route::post('/administradores/guardar', [AdministradorController::class, 'registrar']);

// Alias/Rutas legacy para Administradores
Route::get('/admin/listar', [AdministradorController::class, 'listar'])->name('admin.index');
Route::get('/admin/crear', [AdministradorController::class, 'vistaFormulario']);
Route::post('/admin/guardar', [AdministradorController::class, 'registrar']);
Route::get('/admin/editar/{id?}', [AdministradorController::class, 'vistaEdicion']);
Route::put('/admin/actualizar/{id?}', [AdministradorController::class, 'actualizar']);
Route::get('/admin/mostrar/{id?}', [AdministradorController::class, 'vistaMostrar']);
Route::delete('/admin/borrar/{id?}', [AdministradorController::class, 'borrar']);

// RUTAS CLIENTES
Route::get('/clientes/listado', [ClienteController::class, 'listar']);
Route::get('/clientes/formulario', [ClienteController::class, 'vistaFormulario']);
Route::post('/clientes/formulario', [ClienteController::class, 'registrar']);
Route::post('/clientes/guardar', [ClienteController::class, 'registrar']);

// RUTAS CATEGORÍAS
Route::get('/categorias/listado', [CategoriaController::class, 'listar']);
Route::get('/categorias/formulario', [CategoriaController::class, 'vistaFormulario']);
Route::post('/categorias/guardar', [CategoriaController::class, 'registrar']);

// RUTAS MARCAS
Route::get('/marcas/listado', [MarcaController::class, 'listar']);
Route::get('/marcas/formulario', [MarcaController::class, 'vistaFormulario']);
Route::post('/marcas/guardar', [MarcaController::class, 'registrar']);

// RUTAS TIPOS
Route::get('/tipos/listado', [TipoController::class, 'listar']);
Route::get('/tipos/formulario', [TipoController::class, 'vistaFormulario']);
Route::post('/tipos/guardar', [TipoController::class, 'registrar']);

// RUTAS PRODUCTOS
Route::get('/productos/listado', [ProductoController::class, 'listar']);
Route::get('/productos/formulario', [ProductoController::class, 'vistaFormulario']);
Route::post('/productos/formulario', [ProductoController::class, 'registrar']);
Route::post('/productos/guardar', [ProductoController::class, 'registrar']);
