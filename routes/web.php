<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoPedidoController;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\CategoriaApiController;
use App\Http\Controllers\Api\MarcaApiController;
use App\Http\Controllers\Api\TipoApiController;

// RUTAS PÚBLICAS DE AUTENTICACIÓN

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'vistaLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// RUTAS DE AUTENTICACIÓN GOOGLE SOCIALITE (RED SOCIAL)
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// RUTAS PROTEGIDAS MEDIANTE EL GUARD PERSONALIZADO 'auth:admin'

Route::middleware(['auth:admin'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout']);

    Route::view('/inicio', 'plantilla/layout')->name('dashboard');

    // RUTAS ADMINISTRADORES
    Route::get('/administradores/listado', [AdministradorController::class, 'listar']);
    Route::get('/administradores/formulario', [AdministradorController::class, 'vistaFormulario']);
    Route::post('/administradores/guardar', [AdministradorController::class, 'registrar']);
    Route::get('/administradores/editar/{id}', [AdministradorController::class, 'vistaEdicion']);
    Route::post('/administradores/actualizar/{id}', [AdministradorController::class, 'actualizar']);
    Route::put('/administradores/actualizar/{id}', [AdministradorController::class, 'actualizar']);
    Route::get('/administradores/mostrar/{id}', [AdministradorController::class, 'vistaMostrar']);
    Route::get('/administradores/borrar/{id}', [AdministradorController::class, 'borrar']);
    Route::delete('/administradores/borrar/{id}', [AdministradorController::class, 'borrar']);

    // Alias/Rutas legacy para Administradores
    Route::get('/admin/listar', [AdministradorController::class, 'listar'])->name('admin.index');
    Route::get('/admin/crear', [AdministradorController::class, 'vistaFormulario']);
    Route::post('/admin/guardar', [AdministradorController::class, 'registrar']);
    Route::get('/admin/editar/{id}', [AdministradorController::class, 'vistaEdicion']);
    Route::post('/admin/actualizar/{id}', [AdministradorController::class, 'actualizar']);
    Route::put('/admin/actualizar/{id}', [AdministradorController::class, 'actualizar']);
    Route::get('/admin/mostrar/{id}', [AdministradorController::class, 'vistaMostrar']);
    Route::get('/admin/borrar/{id}', [AdministradorController::class, 'borrar']);
    Route::delete('/admin/borrar/{id}', [AdministradorController::class, 'borrar']);

    // RUTAS CLIENTES
    Route::get('/clientes/listado', [ClienteController::class, 'listar']);
    Route::get('/clientes/formulario', [ClienteController::class, 'vistaFormulario']);
    Route::post('/clientes/formulario', [ClienteController::class, 'registrar']);
    Route::post('/clientes/guardar', [ClienteController::class, 'registrar']);
    Route::get('/clientes/editar/{id}', [ClienteController::class, 'vistaEdicion']);
    Route::post('/clientes/actualizar/{id}', [ClienteController::class, 'actualizar']);
    Route::put('/clientes/actualizar/{id}', [ClienteController::class, 'actualizar']);
    Route::get('/clientes/mostrar/{id}', [ClienteController::class, 'vistaMostrar']);
    Route::get('/clientes/borrar/{id}', [ClienteController::class, 'borrar']);
    Route::delete('/clientes/borrar/{id}', [ClienteController::class, 'borrar']);

    // RUTAS CATEGORÍAS
    Route::get('/categorias/listado', [CategoriaController::class, 'listar']);
    Route::get('/categorias/formulario', [CategoriaController::class, 'vistaFormulario']);
    Route::post('/categorias/guardar', [CategoriaController::class, 'registrar']);
    Route::get('/categorias/editar/{id}', [CategoriaController::class, 'vistaEdicion']);
    Route::post('/categorias/actualizar/{id}', [CategoriaController::class, 'actualizar']);
    Route::put('/categorias/actualizar/{id}', [CategoriaController::class, 'actualizar']);
    Route::get('/categorias/mostrar/{id}', [CategoriaController::class, 'vistaMostrar']);
    Route::get('/categorias/borrar/{id}', [CategoriaController::class, 'borrar']);
    Route::delete('/categorias/borrar/{id}', [CategoriaController::class, 'borrar']);

    // RUTAS MARCAS
    Route::get('/marcas/listado', [MarcaController::class, 'listar']);
    Route::get('/marcas/formulario', [MarcaController::class, 'vistaFormulario']);
    Route::post('/marcas/guardar', [MarcaController::class, 'registrar']);
    Route::get('/marcas/editar/{id}', [MarcaController::class, 'vistaEdicion']);
    Route::post('/marcas/actualizar/{id}', [MarcaController::class, 'actualizar']);
    Route::put('/marcas/actualizar/{id}', [MarcaController::class, 'actualizar']);
    Route::get('/marcas/mostrar/{id}', [MarcaController::class, 'vistaMostrar']);
    Route::get('/marcas/borrar/{id}', [MarcaController::class, 'borrar']);
    Route::delete('/marcas/borrar/{id}', [MarcaController::class, 'borrar']);

    // RUTAS TIPOS
    Route::get('/tipos/listado', [TipoController::class, 'listar']);
    Route::get('/tipos/formulario', [TipoController::class, 'vistaFormulario']);
    Route::post('/tipos/guardar', [TipoController::class, 'registrar']);
    Route::get('/tipos/editar/{id}', [TipoController::class, 'vistaEdicion']);
    Route::post('/tipos/actualizar/{id}', [TipoController::class, 'actualizar']);
    Route::put('/tipos/actualizar/{id}', [TipoController::class, 'actualizar']);
    Route::get('/tipos/mostrar/{id}', [TipoController::class, 'vistaMostrar']);
    Route::get('/tipos/borrar/{id}', [TipoController::class, 'borrar']);
    Route::delete('/tipos/borrar/{id}', [TipoController::class, 'borrar']);

    // RUTAS PRODUCTOS
    Route::get('/productos/listado', [ProductoController::class, 'listar']);
    Route::get('/productos/formulario', [ProductoController::class, 'vistaFormulario']);
    Route::post('/productos/formulario', [ProductoController::class, 'registrar']);
    Route::post('/productos/guardar', [ProductoController::class, 'registrar']);
    Route::get('/productos/editar/{id}', [ProductoController::class, 'vistaEdicion']);
    Route::post('/productos/actualizar/{id}', [ProductoController::class, 'actualizar']);
    Route::put('/productos/actualizar/{id}', [ProductoController::class, 'actualizar']);
    Route::get('/productos/mostrar/{id}', [ProductoController::class, 'vistaMostrar']);
    Route::get('/productos/borrar/{id}', [ProductoController::class, 'borrar']);
    Route::delete('/productos/borrar/{id}', [ProductoController::class, 'borrar']);

    // RUTAS EMPLEADOS
    Route::get('/empleados/listado', [EmpleadoController::class, 'listar']);
    Route::get('/empleados/formulario', [EmpleadoController::class, 'vistaFormulario']);
    Route::post('/empleados/guardar', [EmpleadoController::class, 'registrar']);
    Route::get('/empleados/editar/{id}', [EmpleadoController::class, 'vistaEdicion']);
    Route::post('/empleados/actualizar/{id}', [EmpleadoController::class, 'actualizar']);
    Route::put('/empleados/actualizar/{id}', [EmpleadoController::class, 'actualizar']);
    Route::get('/empleados/mostrar/{id}', [EmpleadoController::class, 'vistaMostrar']);
    Route::get('/empleados/borrar/{id}', [EmpleadoController::class, 'borrar']);
    Route::delete('/empleados/borrar/{id}', [EmpleadoController::class, 'borrar']);

    // RUTAS PEDIDOS
    Route::get('/pedidos/listado', [PedidoController::class, 'listar']);
    Route::get('/pedidos/formulario', [PedidoController::class, 'vistaFormulario']);
    Route::post('/pedidos/guardar', [PedidoController::class, 'registrar']);

    // RUTAS DETALLE DE PEDIDOS (PRODUCTOS_PEDIDOS)
    Route::get('/productos_pedidos/listado', [ProductoPedidoController::class, 'listar']);
    Route::get('/detalles/listado', [ProductoPedidoController::class, 'listar']);
    Route::get('/productos_pedidos/formulario', [ProductoPedidoController::class, 'vistaFormulario']);
    Route::post('/productos_pedidos/guardar', [ProductoPedidoController::class, 'registrar']);
});

// RUTAS API
Route::prefix('api')->group(function () {
    Route::get('/productos', [ProductoApiController::class, 'index']);
    Route::get('/productos/{id}', [ProductoApiController::class, 'show']);
    Route::post('/productos', [ProductoApiController::class, 'store']);
    Route::put('/productos/{id}', [ProductoApiController::class, 'update']);
    Route::delete('/productos/{id}', [ProductoApiController::class, 'destroy']);

    Route::get('/clientes', [ClienteApiController::class, 'index']);
    Route::get('/clientes/{id}', [ClienteApiController::class, 'show']);

    Route::get('/categorias', [CategoriaApiController::class, 'index']);
    Route::get('/categorias/{id}', [CategoriaApiController::class, 'show']);

    Route::get('/marcas', [MarcaApiController::class, 'index']);
    Route::get('/marcas/{id}', [MarcaApiController::class, 'show']);

    Route::get('/tipos', [TipoApiController::class, 'index']);
    Route::get('/tipos/{id}', [TipoApiController::class, 'show']);
});