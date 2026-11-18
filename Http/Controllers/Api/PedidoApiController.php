<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoApiController extends Controller
{
    /**
     * GET /api/pedidos
     * Listar todos los pedidos.
     */
    public function index()
    {
        $pedidos = Pedido::with(['cliente', 'productos_pedido.producto'])->get();

        return response()->json([
            'status' => true,
            'mensaje' => 'Lista de pedidos obtenida exitosamente',
            'data' => $pedidos
        ], 200);
    }

    /**
     * GET /api/pedidos/{id}
     * Consultar pedido por ID.
     */
    public function show($id)
    {
        $pedido = Pedido::with(['cliente', 'productos_pedido.producto'])->find($id);

        if (!$pedido) {
            return response()->json([
                'status' => false,
                'mensaje' => 'El pedido con ID ' . $id . ' no existe'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Pedido encontrado',
            'data' => $pedido
        ], 200);
    }

    /**
     * DELETE /api/pedidos/{id}
     * Eliminar un pedido.
     */
    public function destroy($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json([
                'status' => false,
                'mensaje' => 'No existe el pedido a eliminar'
            ], 404);
        }

        $pedido->delete();

        return response()->json([
            'status' => true,
            'mensaje' => 'Pedido con ID ' . $id . ' eliminado correctamente'
        ], 200);
    }
}
