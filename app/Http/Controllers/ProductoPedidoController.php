<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductoPedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoPedidoController extends Controller
{
    /**
     * Muestra el listado del detalle de productos en pedidos,
     * cargando ansiosamente las relaciones 'pedido.cliente' y 'producto'
     * para mostrar descripciones/nombres en lugar de IDs.
     */
    public function listar()
    {
        $detalles = ProductoPedido::with(['pedido.cliente', 'producto'])->get();
        return view("productos_pedidos/listado", compact("detalles"));
    }

    public function vistaFormulario()
    {
        $pedidos = Pedido::with('cliente')->get();
        $productos = Producto::all();
        return view("productos_pedidos/formulario", compact("pedidos", "productos"));
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pedido_id' => 'required|exists:pedidos,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $detalle = new ProductoPedido();
        $detalle->pedido_id = $request->pedido_id;
        $detalle->producto_id = $request->producto_id;
        $detalle->cantidad = $request->cantidad;
        $detalle->precio = $request->precio;
        $detalle->descuento = $request->descuento ?? 0;

        $detalle->save();

        return redirect('/productos_pedidos/listado')->with('exito', 'Detalle de pedido registrado con éxito');
    }
}
