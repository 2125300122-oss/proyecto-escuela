<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function listar()
    {
        $clientes = Cliente::all();
        return view("clientes/listado", compact("clientes"));
    }

    public function vistaFormulario()
    {
        return view("clientes/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required|email|unique:clientes,correo',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cliente = new Cliente();
        $cliente->nombres = $request->nombres;
        $cliente->apellidos = $request->apellidos;
        $cliente->correo = $request->correo;
        $cliente->contraseña = bcrypt($request->contraseña ?? 'cliente123');
        $cliente->direccion = $request->direccion ?? "Dirección registrada";
        $cliente->imagen = "default_client.png";
        $cliente->estado = 1;

        $cliente->save();

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'cliente_'.$cliente->id.'.'.$extension;
            $carpeta = 'imagenes/clientes';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $cliente->imagen = $ruta;
            $cliente->save();
        }

        return redirect('/clientes/listado')->with('exito', 'Cliente registrado con éxito');
    }

    public function vistaEdicion()
    {
        return view("clientes/edicion");
    }

    public function actualizar(Request $request)
    {
        return redirect('/clientes/listado');
    }

    public function vistaMostrar()
    {
        return view("clientes/mostrar");
    }

    public function borrar()
    {
        return redirect('/clientes/listado');
    }
}
