<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    /**
     * Muestra el listado de todos los empleados de la farmacia.
     */
    public function listar()
    {
        $empleados = Empleado::all();
        return view("empleados/listado", compact("empleados"));
    }

    public function vistaFormulario()
    {
        return view("empleados/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required|email|unique:empleados,correo',
            'usuario' => 'required|unique:empleados,usuario',
            'puesto' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $empleado = new Empleado();
        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->correo = $request->correo;
        $empleado->usuario = $request->usuario;
        $empleado->contraseña = bcrypt($request->contraseña ?? 'emp123');
        $empleado->puesto = $request->puesto;
        $empleado->imagen = "default_empleado.png";
        $empleado->estado = 1;

        $empleado->save();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'empleado_' . $empleado->id . '.' . $extension;
            $carpeta = 'imagenes/empleados';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $empleado->imagen = $ruta;
            $empleado->save();
        }

        return redirect('/empleados/listado')->with('exito', 'Empleado registrado con éxito');
    }
}
