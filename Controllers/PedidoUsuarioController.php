<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PedidoUsuarioController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    private function userClient()
    {
        $token = session('userToken');
        if ($token) {
            return Http::withToken($token)->acceptJson();
        }
        return Http::acceptJson();
    }

    /**
     * 🛒 1. Crear Pedido a partir del Carrito de Compras
     * Descuenta existencias en la BD MySQL de la API y vacía el carrito automáticamente.
     */
    public function crearPedido(Request $request)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login')->with('error', 'Debe iniciar sesión con su cuenta para generar un pedido.');
        }

        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect('/carrito')->with('error', 'Su carrito está vacío. Agregue productos antes de proceder.');
        }

        $items = array_values($carrito);

        // Solicitud POST hacia la API enviando el Token Sanctum y los ítems
        $response = $this->userClient()->post($this->getApiUrl('/cliente/pedidos'), [
            'cliente_id' => session('cliente')['id'] ?? null,
            'items' => $items
        ]);

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            // Vaciar el carrito automáticamente
            session()->forget('carrito');

            $pedidoId = $resData['pedido']['id'] ?? '';
            return redirect('/usuario/pedidos')->with('exito', '¡Pedido #' . $pedidoId . ' generado con éxito! Las existencias se descontaron en la base de datos.');
        }

        $mensajeError = $resData['mensaje'] ?? 'Error al procesar el pedido con la API.';
        return redirect('/carrito')->with('error', $mensajeError);
    }

    /**
     * 📋 2. Consultar el Listado de Pedidos del Usuario Autenticado
     */
    public function misPedidos()
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login')->with('error', 'Inicie sesión para consultar sus pedidos.');
        }

        $response = $this->userClient()->get($this->getApiUrl('/cliente/pedidos'));
        $resData = $response->json();

        $pedidos = $resData['data'] ?? [];

        return view('usuario.pedidos.listado', compact('pedidos'));
    }

    /**
     * 📦 3. Visualizar el Detalle de un Pedido Específico
     */
    public function detallePedido($id)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login')->with('error', 'Inicie sesión para ver el detalle de su pedido.');
        }

        $response = $this->userClient()->get($this->getApiUrl('/cliente/pedidos/' . $id));
        $resData = $response->json();

        $pedido = $resData['data'] ?? null;

        if (!$pedido) {
            return redirect('/usuario/pedidos')->with('error', 'El pedido solicitado no fue encontrado.');
        }

        return view('usuario.pedidos.detalle', compact('pedido'));
    }

    /**
     * 🚫 4. Cancelar Pedido Existente
     * La API cambia el estado a 'Cancelado' y re-incrementa existencias en MySQL.
     */
    public function cancelarPedido($id)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login');
        }

        $response = $this->userClient()->post($this->getApiUrl('/cliente/pedidos/cancelar/' . $id));
        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            return redirect('/usuario/pedidos')->with('exito', 'Pedido #' . $id . ' cancelado exitosamente. Las existencias se restauraron en la base de datos.');
        }

        $mensajeError = $resData['mensaje'] ?? 'No se pudo cancelar el pedido.';
        return redirect('/usuario/pedidos')->with('error', $mensajeError);
    }
}
