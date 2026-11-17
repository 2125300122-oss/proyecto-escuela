<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    // Muestra siempre el formulario de inicio de sesión
    public function vistaLogin()
    {
        return view('auth/login');
    }

    // Proceso de autenticación consumiendo la API vía Http::post
    public function login(Request $request)
    {
        $userInput = $request->input('usuario') ?? $request->input('user') ?? $request->input('username') ?? $request->input('correo');
        $passInput = $request->input('contraseña') ?? $request->input('contrasena') ?? $request->input('password');

        if (!$userInput || !$passInput) {
            return back()->withErrors(['error' => 'Por favor ingrese su usuario/correo y contraseña.'])->withInput();
        }

        // Solicitud HTTP hacia la API de autenticación de administradores
        $response = Http::asForm()->post($this->getApiUrl('/administradores/login'), [
            'usuario' => $userInput,
            'contraseña' => $passInput,
        ]);

        $data = $response->json();

        if ($response->successful() && ($data['status'] ?? false) === true) {
            $token = $data['token'] ?? null;
            $admin = $data['administrador'] ?? null;

            session([
                'adminToken' => $token,
                'admin' => $admin
            ]);

            return redirect('/productos/listado')->with('exito', 'Sesión iniciada correctamente mediante la API');
        }

        $mensajeError = $data['mensaje'] ?? 'Credenciales incorrectas o cuenta inactiva.';
        return back()->withErrors(['error' => $mensajeError])->withInput();
    }

    // Cierre de sesión revocando el token en la API
    public function logout(Request $request)
    {
        $token = session('adminToken');
        if ($token) {
            Http::withToken($token)->post($this->getApiUrl('/administradores/logout'));
        }

        session()->forget(['adminToken', 'admin']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('exito', 'Sesión cerrada correctamente.');
    }
}
