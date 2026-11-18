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

        // Generar código de transacción PayPal Sandbox
        $codigoTx = 'PAYPAL-SANDBOX-TX-' . strtoupper(substr(md5(uniqid()), 0, 10));

        // Solicitud POST hacia la API enviando el Token Sanctum, ítems y código de transacción
        $response = $this->userClient()->post($this->getApiUrl('/cliente/pedidos'), [
            'cliente_id' => session('cliente')['id'] ?? null,
            'items' => $items,
            'codigo_transaccion' => $codigoTx,
        ]);

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            // Vaciar el carrito automáticamente
            session()->forget('carrito');

            $pedidoId = $resData['pedido']['id'] ?? '';
            return redirect('/usuario/pedidos/' . $pedidoId)->with('exito', '¡Pedido #' . $pedidoId . ' creado y pagado vía PayPal Sandbox! Código de Transacción: ' . $codigoTx);
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
     * 💳 4. Procesar Pago vía Pasarela PayPal Sandbox para un Pedido Existente
     */
    public function pagarPedido(Request $request, $id)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login');
        }

        $codigoTx = $request->input('codigo_transaccion') ?? ('PAYPAL-SANDBOX-TX-' . strtoupper(substr(md5(uniqid()), 0, 10)));

        $response = $this->userClient()->post($this->getApiUrl('/cliente/pedidos/pagar/' . $id), [
            'codigo_transaccion' => $codigoTx,
            'metodo_pago' => 'PayPal Sandbox'
        ]);

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            return redirect('/usuario/pedidos/' . $id)->with('exito', '¡Pago registrado exitosamente! Código de Transacción: ' . $codigoTx);
        }

        return redirect('/usuario/pedidos/' . $id)->with('error', $resData['mensaje'] ?? 'Error al procesar el pago.');
    }

    /**
     * 📜 5. Consultar Estado de los Pagos Realizados por el Cliente
     */
    public function historialPagos()
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login')->with('error', 'Inicie sesión para ver su historial de pagos.');
        }

        $response = $this->userClient()->get($this->getApiUrl('/cliente/pagos'));
        $resData = $response->json();
        $pagos = $resData['data'] ?? [];

        return view('usuario.pagos', compact('pagos'));
    }

    /**
     * 🚫 6. Cancelar Pedido Existente
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
