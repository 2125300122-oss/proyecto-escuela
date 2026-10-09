<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class ClienteApiController extends Controller
{
    public function index()
    {
        $clientes = Cliente::where('estado', 1)->get();
        return response()->json([
            'status' => true,
            'mensaje' => 'Lista de clientes obtenida correctamente',
            'data' => $clientes
        ], 200);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Cliente con ID ' . $id . ' no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Cliente encontrado',
            'data' => $cliente
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo',
            'direccion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $cliente = new Cliente();
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->correo = $request->correo;
        $cliente->contraseña = bcrypt($request->contraseña ?? 'cliente123');
        $cliente->direccion = $request->direccion;
        $cliente->imagen = "imagenes/clientes/cliente_default.png";
        $cliente->estado = 1;

        $cliente->save();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'cliente_' . $cliente->id . '.' . $extension;
            $carpeta = 'imagenes/clientes';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $cliente->imagen = $ruta;
            $cliente->save();
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Cliente registrado correctamente',
            'data' => $cliente
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Cliente no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo,' . $id,
            'direccion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->correo = $request->correo;
        $cliente->direccion = $request->direccion;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'cliente_' . $cliente->id . '.' . $extension;
            $carpeta = 'imagenes/clientes';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $cliente->imagen = $ruta;
        }

        $cliente->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Cliente actualizado correctamente',
            'data' => $cliente
        ], 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Cliente no encontrado'
            ], 404);
        }

        $cliente->estado = 0;
        $cliente->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Cliente con ID ' . $id . ' eliminado con éxito'
        ], 200);
    }
}
