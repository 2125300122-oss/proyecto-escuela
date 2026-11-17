<?php

namespace App\Http\Controllers\Api;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Tipo;
use App\Models\Marca;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Validator;

class ProductoApiController extends Controller
{
    /**
     * GET /api/productos
     * Retorna la lista de productos activos en formato JSON con relaciones resueltas.
     */
    public function index()
    {
        $productos = Producto::with(['categoria', 'tipo', 'marca'])->get();

        return response()->json($productos);
    }
        //     'status' => true,
        //     'mensaje' => 'Lista de productos obtenida correctamente',
        //     'data' => $productos
        // ], 200);
    
    
    

    public function show($id)
    {
         $producto = Producto::with(['categoria', 'tipo', 'marca'])->find($id);

         if (!$producto) {
            return response()->json([
                'status' => false,
                'mensaje' => 'El producto solicitado con ID ' . $id . ' no existe en la base de datos'
            ], 404);
        }

         return response()->json([
            'status' => true,
            'mensaje' => 'Producto encontrado',
            'data' => $producto
        ], 200);
    }

    /**
     * POST /api/productos
     * Crea un nuevo producto asignando valores por defecto si los campos vienen vacíos o no se especifican en Postman.
     */
    public function store(Request $request)
    {
        $producto = new Producto();
        $producto->nombre = !empty($request->nombre) ? $request->nombre : 'Producto API ' . rand(100, 999);
        $producto->descripcion = !empty($request->descripcion) ? $request->descripcion : 'Descripción registrada desde la API';
        $producto->categoria_id = !empty($request->categoria_id) ? $request->categoria_id : 1;
        $producto->tipo_id = !empty($request->tipo_id) ? $request->tipo_id : 1;
        $producto->marca_id = !empty($request->marca_id) ? $request->marca_id : 1;
        $producto->precio = is_numeric($request->precio) ? $request->precio : 50.00;
        $producto->existencia = is_numeric($request->existencia) ? (int)$request->existencia : 20;
        $producto->descuento = is_numeric($request->descuento) ? $request->descuento : 0;
        $producto->imagen1 = "imagenes/productos/producto_default.png";
        $producto->imagen2 = "imagenes/productos/producto_default.png";
        $producto->imagen3 = "imagenes/productos/producto_default.png";
        $producto->estado = 1;

        if ($request->hasFile('imagen1')) {
            $publicUrl = ImageUploadService::uploadImage($request->file('imagen1'));
            if ($publicUrl) {
                $producto->imagen1 = $publicUrl;
            }
        }

        $producto->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Producto registrado con éxito mediante la API REST',
            'data' => $producto->load(['categoria', 'tipo', 'marca'])
        ], 201);
    }

    /**
     * PUT /api/productos/{id}
     * Actualiza un producto existente.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => false,
                'mensaje' => 'No se encontró el producto con ID ' . $id . ' para actualizar'
            ], 404);
        }

        $producto->nombre = !empty($request->nombre) ? $request->nombre : $producto->nombre;
        $producto->descripcion = !empty($request->descripcion) ? $request->descripcion : $producto->descripcion;
        $producto->categoria_id = !empty($request->categoria_id) ? $request->categoria_id : $producto->categoria_id;
        $producto->tipo_id = !empty($request->tipo_id) ? $request->tipo_id : $producto->tipo_id;
        $producto->marca_id = !empty($request->marca_id) ? $request->marca_id : $producto->marca_id;
        $producto->precio = is_numeric($request->precio) ? $request->precio : $producto->precio;
        $producto->existencia = is_numeric($request->existencia) ? (int)$request->existencia : $producto->existencia;
        $producto->descuento = is_numeric($request->descuento) ? $request->descuento : $producto->descuento;

        if ($request->hasFile('imagen1')) {
            $publicUrl = ImageUploadService::uploadImage($request->file('imagen1'));
            if ($publicUrl) {
                $producto->imagen1 = $publicUrl;
            }
        }

        $producto->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Producto actualizado correctamente vía API',
            'data' => $producto->load(['categoria', 'tipo', 'marca'])
        ], 200);
    }

    /**
     * DELETE /api/productos/{id}
     * Elimina (borrado lógico) un producto.
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => false,
                'mensaje' => 'No existe el producto con ID ' . $id . ' para eliminar'
            ], 404);
        }

        $producto->estado = 0;
        $producto->save();

        return response()->json([
            'status' => true,
            'mensaje' => 'Producto con ID ' . $id . ' eliminado exitosamente'
        ], 200);
    }
}
