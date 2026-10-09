<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class CategoriaApiController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('estado', 1)->get();
        return response()->json([
            'status' => true,
            'mensaje' => 'Lista de categorías obtenida correctamente',
            'data' => $categorias
        ], 200);
    }

    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Categoría no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Categoría encontrada',
            'data' => $categoria
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->imagen = "imagenes/categorias/categoria_default.png";
        $categoria->estado = 1;
        $categoria->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Categoría registrada con éxito',
            'data' => $categoria
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Categoría no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Error de validación',
                'errores' => $validator->errors()
            ], 422);
        }

        $categoria->nombre = $request->nombre;
        $categoria->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Categoría actualizada con éxito',
            'data' => $categoria
        ], 200);
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Categoría no encontrada'
            ], 404);
        }

        $categoria->estado = 0;
        $categoria->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Categoría eliminada con éxito'
        ], 200);
    }
}
