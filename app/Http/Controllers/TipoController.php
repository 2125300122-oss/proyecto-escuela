<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use Illuminate\Support\Facades\Validator;

class TipoController extends Controller
{
    public function listar()
    {
        $tipos = Tipo::where('estado', 1)->get();
        return view("tipos/listado", compact("tipos"));
    }

    public function vistaFormulario()
    {
        return view("tipos/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:tipos,nombre',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tipo = new Tipo();
        $tipo->nombre = $request->nombre;
        $tipo->imagen = "imagenes/tipos/tipo_default.png";
        $tipo->estado = 1;

        $tipo->save();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'tipo_' . $tipo->id . '.' . $extension;
            $carpeta = 'imagenes/tipos';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $tipo->imagen = $ruta;
            $tipo->save();
        }

        return redirect('/tipos/listado')->with('exito', 'Tipo registrado con éxito');
    }

    public function vistaEdicion($id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return redirect('/tipos/listado')->with('error', 'El tipo de presentación especificado no existe en la base de datos.');
        }

        return view("tipos/edicion", compact("tipo"));
    }

    public function actualizar(Request $request, $id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return redirect('/tipos/listado')->with('error', 'No se pudo actualizar: el tipo no existe en la base de datos.');
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:tipos,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tipo->nombre = $request->nombre;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'tipo_' . $tipo->id . '.' . $extension;
            $carpeta = 'imagenes/tipos';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $tipo->imagen = $ruta;
        }

        $tipo->save();

        return redirect('/tipos/listado')->with('exito', 'Tipo de presentación #' . $tipo->id . ' actualizado correctamente');
    }

    public function vistaMostrar($id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return redirect('/tipos/listado')->with('error', 'El tipo solicitado no existe en la base de datos.');
        }

        return view("tipos/mostrar", compact("tipo"));
    }

    public function borrar($id)
    {
        $tipo = Tipo::find($id);

        if (!$tipo) {
            return redirect('/tipos/listado')->with('error', 'No se pudo eliminar: el tipo no existe en la base de datos.');
        }

        $tipo->estado = 0;
        $tipo->save();

        return redirect('/tipos/listado')->with('exito', 'Tipo de presentación #' . $id . ' eliminado con éxito.');
    }
}
