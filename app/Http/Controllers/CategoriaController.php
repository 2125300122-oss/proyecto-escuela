<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function listar()
    {
        $categorias = Categoria::all();
        return view("categorias/listado", compact("categorias"));
    }

    public function vistaFormulario()
    {
        return view("categorias/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:categorias,nombre',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->imagen = "default_categoria.png";
        $categoria->estado = 1;

        $categoria->save();

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'categoria_'.$categoria->id.'.'.$extension;
            $carpeta = 'imagenes/categorias';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $categoria->imagen = $ruta;
            $categoria->save();
        }

        return redirect('/categorias/listado')->with('exito', 'Categoría registrada con éxito');
    }
}
