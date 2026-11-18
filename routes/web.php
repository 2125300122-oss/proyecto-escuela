<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PedidoUsuarioController;

/*
|--------------------------------------------------------------------------
| RUTAS DEL CLIENTE FINAL (SIN BASE DE DATOS LOCAL - CONSUMO API REST)
|--------------------------------------------------------------------------
*/

// 🏠 1. Página de Inicio
Route::get('/', [PaginasController::class, 'inicio']);
Route::get('/inicio', [PaginasController::class, 'inicio']);

// 👥 2. Página Nosotros
Route::get('/nosotros', [PaginasController::class, 'nosotros']);

// 🛍️ 3. Catálogo de productos (Consumiendo GET /api/productos)
Route::get('/catalogo', [CatalogoController::class, 'index']);

// 📦 4. Detalle del producto con las 3 imágenes (Consumiendo GET /api/productos/{id})
Route::get('/catalogo/detalle/{id}', [CatalogoController::class, 'show']);

// 📩 5. Página Contacto
Route::get('/contacto', [PaginasController::class, 'contacto']);

// 🛒 6. RUTAS DEL CARRITO DE COMPRAS (GESTIONADO VÍA SESIÓN)
Route::get('/carrito', [CarritoController::class, 'index']);
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar']);
Route::post('/carrito/actualizar/{id}', [CarritoController::class, 'actualizar']);
Route::get('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar']);
Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar']);
Route::get('/carrito/vaciar', [CarritoController::class, 'vaciar']);
Route::post('/carrito/vaciar', [CarritoController::class, 'vaciar']);

// 👤 7. RUTAS DE AUTENTICACIÓN Y GESTIÓN DE PERFIL DE USUARIO / CLIENTE (CON TOKEN SANCTUM)
Route::get('/usuario/registro', [UsuarioController::class, 'vistaRegistro']);
Route::post('/usuario/registro', [UsuarioController::class, 'registro']);

Route::get('/usuario/login', [UsuarioController::class, 'vistaLogin']);
Route::post('/usuario/login', [UsuarioController::class, 'login']);

Route::get('/usuario/logout', [UsuarioController::class, 'logout']);
Route::post('/usuario/logout', [UsuarioController::class, 'logout']);

Route::get('/usuario/perfil', [UsuarioController::class, 'perfil']);
Route::post('/usuario/perfil/actualizar', [UsuarioController::class, 'actualizarPerfil']);
Route::post('/usuario/perfil/imagen', [UsuarioController::class, 'actualizarImagen']);
Route::post('/usuario/perfil/password', [UsuarioController::class, 'actualizarPassword']);

// 📋 8. RUTAS DE GESTIÓN DE PEDIDOS DEL CLIENTE (CON TOKEN SANCTUM Y CLIENTE_ID)
Route::post('/pedidos/crear', [PedidoUsuarioController::class, 'crearPedido']);
Route::get('/usuario/pedidos', [PedidoUsuarioController::class, 'misPedidos']);
Route::get('/usuario/pedidos/{id}', [PedidoUsuarioController::class, 'detallePedido']);
Route::post('/usuario/pedidos/cancelar/{id}', [PedidoUsuarioController::class, 'cancelarPedido']);
Route::get('/usuario/pedidos/cancelar/{id}', [PedidoUsuarioController::class, 'cancelarPedido']);

// 💳 9. RUTAS DE PASARELA DE PAGO PAYPAL SANDBOX Y ESTADO DE PAGOS
Route::post('/usuario/pedidos/pagar/{id}', [PedidoUsuarioController::class, 'pagarPedido']);
Route::get('/usuario/pedidos/pagar/{id}', [PedidoUsuarioController::class, 'pagarPedido']);
Route::get('/usuario/pagos', [PedidoUsuarioController::class, 'historialPagos']);

// Alias/Compatibilidad
Route::get('/login', [UsuarioController::class, 'vistaLogin']);
Route::post('/login', [UsuarioController::class, 'login']);
Route::get('/logout', [UsuarioController::class, 'logout']);
