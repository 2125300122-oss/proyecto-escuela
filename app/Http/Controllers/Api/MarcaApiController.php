<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class MarcaApiController extends Controller
{
    public function index()
    {
        $marcas = Marca::where('estado', 1)->get();
        return response()->json([
            'status' => true,
            'mensaje' => 'Lista de marcas obtenida correctamente',
            'data' => $marcas
        ], 200);
    }

    public function show($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Marca no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Marca encontrada',
            'data' => $marca
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:marcas,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $marca = new Marca();
        $marca->nombre = $request->nombre;
        $marca->imagen = "imagenes/marcas/marca_default.png";
        $marca->estado = 1;
        $marca->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Marca registrada con éxito',
            'data' => $marca
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Marca no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:marcas,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $marca->nombre = $request->nombre;
        $marca->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Marca actualizada con éxito',
            'data' => $marca
        ], 200);
    }

    public function destroy($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Marca no encontrada'
            ], 404);
        }

        $marca->estado = 0;
        $marca->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Marca eliminada con éxito'
        ], 200);
    }
}
