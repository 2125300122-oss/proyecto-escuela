<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use Illuminate\Support\Facades\Validator;

class MarcaController extends Controller
{
    public function listar()
    {
        $marcas = Marca::all();
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
        $marca->imagen = "default_marca.png";
        $marca->estado = 1;

        $marca->save();

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'marca_'.$marca->id.'.'.$extension;
            $carpeta = 'imagenes/marcas';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $marca->imagen = $ruta;
            $marca->save();
        }

        return redirect('/marcas/listado')->with('exito', 'Marca registrada con éxito');
    }
}
