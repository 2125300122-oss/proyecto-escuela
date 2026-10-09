<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Administrador;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //  Muestra el formulario de inicio de sesión manual.
     
    public function vistaLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/productos/listado');
        }

        return view('auth/login');
    }

    //   Proceso manual de autenticación con el guard personalizado 'admin'.
     
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'contraseña' => 'required',
        ], [
            'usuario.required' => 'El campo usuario o correo es obligatorio.',
            'contraseña.required' => 'Debes ingresar tu contraseña.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 1. Verificación previa de administrador activo/desactivado en BD
        $admin = Administrador::where('usuario', $request->usuario)
                    ->orWhere('correo', $request->usuario)
                    ->first();

        if ($admin && ($admin->estado == 0 || $admin->activo == 0)) {
            return back()->withErrors(['status' => 'Esta cuenta se encuentra desactivada por el administrador.'])->withInput();
        }

        // 'password' es la llave interna obligatoria de Laravel (mapeada a 'contraseña' en el modelo)
        $credencialesUsuario = [
            'usuario'  => $request->usuario,
            'password' => $request->contraseña,
            'estado'   => 1
        ];

        $credencialesCorreo = [
            'correo'   => $request->usuario,
            'password' => $request->contraseña,
            'estado'   => 1
        ];

        if (Auth::guard('admin')->attempt($credencialesUsuario) || Auth::guard('admin')->attempt($credencialesCorreo)) {
            $request->session()->regenerate();
            return redirect()->intended('/productos/listado');
        }

        return back()->withErrors(['error' => 'Credenciales incorrectas o cuenta inactiva.'])->withInput();
    }

    //  Proceso de cierre de sesión manual.
     
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('exito', 'Sesión cerrada correctamente.');
    }
}
