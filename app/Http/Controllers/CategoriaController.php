<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function listar()
    {
        $categorias = Categoria::where('estado', 1)->get();
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
        $categoria->imagen = "imagenes/categorias/categoria_default.png";
        $categoria->estado = 1;

        $categoria->save();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'categoria_' . $categoria->id . '.' . $extension;
            $carpeta = 'imagenes/categorias';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $categoria->imagen = $ruta;
            $categoria->save();
        }

        return redirect('/categorias/listado')->with('exito', 'Categoría registrada con éxito');
    }

    public function vistaEdicion($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect('/categorias/listado')->with('error', 'La categoría especificada no existe en la base de datos.');
        }

        return view("categorias/edicion", compact("categoria"));
    }

    public function actualizar(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect('/categorias/listado')->with('error', 'No se pudo actualizar: la categoría no existe en la base de datos.');
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria->nombre = $request->nombre;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'categoria_' . $categoria->id . '.' . $extension;
            $carpeta = 'imagenes/categorias';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $categoria->imagen = $ruta;
        }

        $categoria->save();

        return redirect('/categorias/listado')->with('exito', 'Categoría #' . $categoria->id . ' actualizada correctamente');
    }

    public function vistaMostrar($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect('/categorias/listado')->with('error', 'La categoría solicitada no existe en la base de datos.');
        }

        return view("categorias/mostrar", compact("categoria"));
    }

    public function borrar($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect('/categorias/listado')->with('error', 'No se pudo eliminar: la categoría no existe en la base de datos.');
        }

        $categoria->estado = 0;
        $categoria->save();

        return redirect('/categorias/listado')->with('exito', 'Categoría #' . $id . ' eliminada con éxito.');
    }
}
