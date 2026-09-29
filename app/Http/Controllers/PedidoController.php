<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class PedidoController extends Controller
{
    /**
     * Muestra el listado de todos los pedidos/ventas realizado en la farmacia,
     * cargando la relación 'cliente' para mostrar su nombre en lugar del ID.
     */
    public function listar()
    {
        $pedidos = Pedido::with('cliente')->get();
        return view("pedidos/listado", compact("pedidos"));
    }

    public function vistaFormulario()
    {
        $clientes = Cliente::all();
        return view("pedidos/formulario", compact("clientes"));
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required',
            'total' => 'required|numeric',
            'estado' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pedido = new Pedido();
        $pedido->cliente_id = $request->cliente_id;
        $pedido->fecha = $request->fecha;
        $pedido->iva = $request->iva ?? ($request->total * 0.16);
        $pedido->descuento = $request->descuento ?? 0;
        $pedido->total = $request->total;
        $pedido->estado = $request->estado;

        $pedido->save();

        return redirect('/pedidos/listado')->with('exito', 'Pedido registrado con éxito');
    }
}
