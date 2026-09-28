<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use Illuminate\Support\Facades\Validator;

class TipoController extends Controller
{
    public function listar()
    {
        $tipos = Tipo::all();
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
        $tipo->imagen = "default_tipo.png";
        $tipo->estado = 1;

        $tipo->save();

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'tipo_'.$tipo->id.'.'.$extension;
            $carpeta = 'imagenes/tipos';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $tipo->imagen = $ruta;
            $tipo->save();
        }

        return redirect('/tipos/listado')->with('exito', 'Tipo registrado con éxito');
    }
}
