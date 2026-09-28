<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Tipo;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function listar()
    {
        $productos = Producto::all();
        return view("productos/listado", compact("productos"));
    }

    public function vistaFormulario()
    {
        $categorias = Categoria::all();
        $tipos = Tipo::all();
        $marcas = Marca::all();

        return view("productos/formulario", compact("categorias", "tipos", "marcas"));
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'categoria_id' => 'required',
            'tipo_id' => 'required',
            'marca_id' => 'required',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
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
        $producto->imagen1 = "default_prod1.png";
        $producto->imagen2 = "default_prod2.png";
        $producto->imagen3 = "default_prod3.png";
        $producto->estado = 1;

        $producto->save();

        if($request->hasFile('imagen1')){
            $imagen = $request->file('imagen1');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'producto_'.$producto->id.'_1.'.$extension;
            $carpeta = 'imagenes/productos';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $producto->imagen1 = $ruta;
            $producto->save();
        }

        return redirect('/productos/listado')->with('exito', 'Producto registrado con éxito');
    }

    public function vistaEdicion()
    {
        return view("productos/edicion");
    }

    public function actualizar(Request $request)
    {
        return redirect('/productos/listado');
    }

    public function vistaMostrar()
    {
        return view("productos/mostrar");
    }

    public function borrar()
    {
        return redirect('/productos/listado');
    }
}
