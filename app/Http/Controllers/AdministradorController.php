<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Validator;

class AdministradorController extends Controller
{
    public function listar()
    {
        $admins = Administrador::where('estado', 1)->get();
        return view("administradores/listado", compact("admins"));
    }

    public function vistaFormulario()
    {
        return view("administradores/formulario");
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'correo' => 'required|email|unique:administradores,correo',
            'usuario' => 'required|unique:administradores,usuario',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = new Administrador();
        $admin->nombres = $request->nombres;
        $admin->apellidos = $request->apellidos;
        $admin->correo = $request->correo;
        $admin->usuario = $request->usuario;
        $admin->contraseña = bcrypt($request->contraseña ?? $request->contrasena ?? '123456');
        $admin->imagen = "imagenes/administradores/administrador_default.png";
        $admin->rol = $request->rol ?? 'Administrador';
        $admin->estado = $request->estado ?? 1;

        $admin->save();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'administrador_' . $admin->id . '.' . $extension;
            $carpeta = 'imagenes/administradores';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $admin->imagen = $ruta;
            $admin->save();
        }

        return redirect('/administradores/listado')->with('exito', 'Administrador registrado con éxito');
    }

    public function vistaEdicion($id = null)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return redirect('/administradores/listado')->with('error', 'El administrador especificado no existe en la base de datos.');
        }

        return view("administradores/edicion", compact("admin"));
    }

    public function actualizar(Request $request, $id = null)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return redirect('/administradores/listado')->with('error', 'No se pudo actualizar: el administrador no existe en la base de datos.');
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|unique:administradores,correo,' . $id,
            'usuario' => 'required|string|unique:administradores,usuario,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin->nombres = $request->nombres;
        $admin->apellidos = $request->apellidos;
        $admin->correo = $request->correo;
        $admin->usuario = $request->usuario;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'administrador_' . $admin->id . '.' . $extension;
            $carpeta = 'imagenes/administradores';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $admin->imagen = $ruta;
        }

        $admin->save();

        return redirect('/administradores/listado')->with('exito', 'Administrador #' . $admin->id . ' actualizado correctamente');
    }

    public function vistaMostrar($id = null)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return redirect('/administradores/listado')->with('error', 'El administrador solicitado no existe en la base de datos.');
        }

        return view("administradores/mostrar", compact("admin"));
    }

    public function borrar($id = null)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return redirect('/administradores/listado')->with('error', 'No se pudo eliminar: el administrador no existe en la base de datos.');
        }

        $admin->estado = 0;
        $admin->save();

        return redirect('/administradores/listado')->with('exito', 'Administrador #' . $id . ' eliminado con éxito.');
    }
}
