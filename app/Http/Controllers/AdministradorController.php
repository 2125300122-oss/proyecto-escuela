<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Validator;

class AdministradorController extends Controller
{
    public function listar(){
        $admins = Administrador::all();
        return view("/administradores/listado", compact("admins"));
    }

    public function vistaFormulario(){
        return view("/administradores/formulario");
    }

    public function registrar(Request $request){
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
        $admin->imagen = "/imagenes/administradores/admin_default.jpg";
        $admin->rol = $request->rol ?? 'Administrador';
        $admin->estado = $request->estado ?? 1;

        $admin->save();

        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $nuevoNombre = 'administrador_'.$admin->id.'.'.$extension;
            $carpeta = 'imagenes/administradores';
            $ruta = $imagen->storeAs($carpeta, $nuevoNombre, 'public');
            $admin->imagen = $ruta;
            $admin->save();
        }

        return redirect('/administradores/listado')->with('exito', 'Administrador registrado con éxito');
    }

    public function vistaEdicion($id = null){
        $admin = $id ? Administrador::find($id) : null;
        return view("/administradores/edicion", compact("admin"));
    }

    public function actualizar(Request $request, $id = null){
        if ($id && $admin = Administrador::find($id)) {
            $admin->nombres = $request->nombres ?? $admin->nombres;
            $admin->apellidos = $request->apellidos ?? $admin->apellidos;
            $admin->correo = $request->correo ?? $admin->correo;
            $admin->usuario = $request->usuario ?? $admin->usuario;
            $admin->save();
        }
        return redirect('/administradores/listado')->with('exito', 'Administrador actualizado con éxito');
    }

    public function vistaMostrar($id = null){
        $admin = $id ? Administrador::find($id) : null;
        return view("/administradores/mostrar", compact("admin"));
    }

    public function borrar($id = null){
        if ($id && $admin = Administrador::find($id)) {
            $admin->delete();
        }
        return redirect('/administradores/listado')->with('exito', 'Administrador eliminado con éxito');
    }
}
