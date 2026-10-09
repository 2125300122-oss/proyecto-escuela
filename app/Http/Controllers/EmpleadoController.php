<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Validator;

class EmpleadoController extends Controller
{
    public function listar()
    {
        $empleados = Empleado::where('estado', 1)->get();
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
        $empleado->imagen = "imagenes/empleados/empleado_default.png";
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

    public function vistaEdicion($id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return redirect('/empleados/listado')->with('error', 'El empleado especificado no existe en la base de datos.');
        }

        return view("empleados/edicion", compact("empleado"));
    }

    public function actualizar(Request $request, $id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return redirect('/empleados/listado')->with('error', 'No se pudo actualizar: el empleado no existe en la base de datos.');
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:empleados,correo,' . $id,
            'usuario' => 'required|string|unique:empleados,usuario,' . $id,
            'puesto' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->correo = $request->correo;
        $empleado->usuario = $request->usuario;
        $empleado->puesto = $request->puesto;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'empleado_' . $empleado->id . '.' . $extension;
            $carpeta = 'imagenes/empleados';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $empleado->imagen = $ruta;
        }

        $empleado->save();

        return redirect('/empleados/listado')->with('exito', 'Empleado #' . $empleado->id . ' actualizado correctamente');
    }

    public function vistaMostrar($id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return redirect('/empleados/listado')->with('error', 'El empleado solicitado no existe en la base de datos.');
        }

        return view("empleados/mostrar", compact("empleado"));
    }

    public function borrar($id)
    {
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return redirect('/empleados/listado')->with('error', 'No se pudo eliminar: el empleado no existe en la base de datos.');
        }

        $empleado->estado = 0;
        $empleado->save();

        return redirect('/empleados/listado')->with('exito', 'Empleado #' . $id . ' eliminado con éxito.');
    }
}
