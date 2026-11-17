<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PedidoController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    private function client()
    {
        $token = session('adminToken');
        if ($token) {
            return Http::withToken($token)->acceptJson();
        }
        return Http::acceptJson();
    }

    public function listar()
    {
        $response = $this->client()->get($this->getApiUrl('/pedidos'));
        $pedidos = $response->json()['data'] ?? [];

        return view("pedidos/listado", compact("pedidos"));
    }

    public function vistaMostrar($id)
    {
        $response = $this->client()->get($this->getApiUrl('/pedidos/' . $id));
        $pedido = $response->json()['data'] ?? null;

        if (!$pedido) {
            return redirect('/pedidos/listado')->with('error', 'El pedido solicitado no existe.');
        }

        return view("pedidos/mostrar", compact("pedido"));
    }

    public function borrar($id)
    {
        $response = $this->client()->delete($this->getApiUrl('/pedidos/' . $id));

        if ($response->successful()) {
            return redirect('/pedidos/listado')->with('exito', 'Pedido #' . $id . ' eliminado con éxito vía API.');
        }

        return redirect('/pedidos/listado')->with('error', 'Error al eliminar pedido vía API.');
    }
}
