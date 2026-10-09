<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoApiController extends Controller
{
    /**
     * GET /api/productos
     * Retorna la lista de productos activos en formato JSON con relaciones resueltas.
     */
    public function index()
    {
        $productos = Producto::where('estado', 1)->with(['categoria', 'tipo', 'marca'])->get();

        return response()->json([
            'status' => true,
            'mensaje' => 'Lista de productos obtenida correctamente',
            'data' => $productos
        ], 200);
    }

    /**
     * GET /api/productos/{id}
     * Retorna un producto específico por ID.
     */
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
     * Crea un nuevo producto validando la entrada de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_id' => 'required|exists:tipos,id',
            'marca_id' => 'required|exists:marcas,id',
            'precio' => 'required|numeric|min:0',
            'existencia' => 'required|integer|min:0',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Errores de validación en la petición',
                'errores' => $validator->errors()
            ], 422);
        }

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->tipo_id = $request->tipo_id;
        $producto->marca_id = $request->marca_id;
        $producto->precio = $request->precio;
        $producto->existencia = $request->existencia;
        $producto->descuento = $request->descuento ?? 0;
        $producto->imagen1 = "imagenes/productos/producto_default.png";
        $producto->imagen2 = "imagenes/productos/producto_default.png";
        $producto->imagen3 = "imagenes/productos/producto_default.png";
        $producto->estado = 1;

        $producto->save();

        if ($request->hasFile('imagen1')) {
            $imagen = $request->file('imagen1');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'producto_' . $producto->id . '.' . $extension;
            $carpeta = 'imagenes/productos';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $producto->imagen1 = $ruta;
            $producto->save();
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Producto creado con éxito en la API',
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

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_id' => 'required|exists:tipos,id',
            'marca_id' => 'required|exists:marcas,id',
            'precio' => 'required|numeric|min:0',
            'existencia' => 'required|integer|min:0',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Errores de validación en la actualización',
                'errores' => $validator->errors()
            ], 422);
        }

        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->tipo_id = $request->tipo_id;
        $producto->marca_id = $request->marca_id;
        $producto->precio = $request->precio;
        $producto->existencia = $request->existencia;
        $producto->descuento = $request->descuento ?? $producto->descuento;

        if ($request->hasFile('imagen1')) {
            $imagen = $request->file('imagen1');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'producto_' . $producto->id . '.' . $extension;
            $carpeta = 'imagenes/productos';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $producto->imagen1 = $ruta;
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
