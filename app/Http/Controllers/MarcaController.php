<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{
    public function listar()
    {
        $marcas = Marca::where('estado', 1)->get();
        return view("marcas/listado", compact("marcas"));
    }

    public function vistaFormulario()
    {
        return view("marcas/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:marcas,nombre',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $marca = new Marca();
        $marca->nombre = $request->nombre;
        $marca->imagen = "imagenes/marcas/marca_default.png";
        $marca->estado = 1;

        $marca->save();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'marca_' . $marca->id . '.' . $extension;
            $carpeta = 'imagenes/marcas';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $marca->imagen = $ruta;
            $marca->save();
        }

        return redirect('/marcas/listado')->with('exito', 'Marca registrada con éxito');
    }

    public function vistaEdicion($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return redirect('/marcas/listado')->with('error', 'La marca especificada no existe en la base de datos.');
        }

        return view("marcas/edicion", compact("marca"));
    }

    public function actualizar(Request $request, $id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return redirect('/marcas/listado')->with('error', 'No se pudo actualizar: la marca no existe en la base de datos.');
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:marcas,nombre,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $marca->nombre = $request->nombre;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'marca_' . $marca->id . '.' . $extension;
            $carpeta = 'imagenes/marcas';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $marca->imagen = $ruta;
        }

        $marca->save();

        return redirect('/marcas/listado')->with('exito', 'Marca #' . $marca->id . ' actualizada correctamente');
    }

    public function vistaMostrar($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return redirect('/marcas/listado')->with('error', 'La marca solicitada no existe en la base de datos.');
        }

        return view("marcas/mostrar", compact("marca"));
    }

    public function borrar($id)
    {
        $marca = Marca::find($id);

        if (!$marca) {
            return redirect('/marcas/listado')->with('error', 'No se pudo eliminar: la marca no existe en la base de datos.');
        }

        $marca->estado = 0;
        $marca->save();

        return redirect('/marcas/listado')->with('exito', 'Marca #' . $id . ' eliminada con éxito.');
    }
}
