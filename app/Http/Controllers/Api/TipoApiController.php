<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipo;
use Illuminate\Support\Facades\Validator;

class TipoApiController extends Controller
{
    public function index()
    {
        $tipos = Tipo::where('estado', 1)->get();
        return response()->json([
            'status' => true,
            'mensaje' => 'Lista de tipos obtenida correctamente',
            'data' => $tipos
        ], 200);
    }

    public function show($id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Tipo de presentación no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Tipo encontrado',
            'data' => $tipo
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:tipos,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $tipo = new Tipo();
        $tipo->nombre = $request->nombre;
        $tipo->imagen = "imagenes/tipos/tipo_default.png";
        $tipo->estado = 1;
        $tipo->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Tipo registrado con éxito',
            'data' => $tipo
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Tipo de presentación no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:tipos,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $tipo->nombre = $request->nombre;
        $tipo->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Tipo actualizado con éxito',
            'data' => $tipo
        ], 200);
    }

    public function destroy($id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Tipo no encontrado'
            ], 404);
        }

        $tipo->estado = 0;
        $tipo->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Tipo eliminado con éxito'
        ], 200);
    }
}
