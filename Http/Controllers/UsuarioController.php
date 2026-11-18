<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'http://127.0.0.1:8000/api');
        return rtrim($baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

    private function userClient()
    {
        $token = session('userToken');
        if ($token) {
            return Http::withToken($token)->acceptJson();
        }
        return Http::acceptJson();
    }

    // 1. VISTA Y PROCESO DE REGISTRO
    public function vistaRegistro()
    {
        if (session()->has('userToken')) {
            return redirect('/usuario/perfil');
        }
        return view('usuario.registro');
    }

    public function registro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
            'contraseña' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña,
            'direccion' => $request->direccion ?? 'Dirección no especificada',
        ];

        if ($request->hasFile('imagen')) {
            $response = Http::attach(
                'imagen',
                file_get_contents($request->file('imagen')->path()),
                $request->file('imagen')->getClientOriginalName()
            )->post($this->getApiUrl('/cliente/registro'), $data);
        } else {
            $response = Http::asForm()->post($this->getApiUrl('/cliente/registro'), $data);
        }

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            session([
                'userToken' => $resData['token'],
                'cliente' => $resData['cliente']
            ]);

            return redirect('/usuario/perfil')->with('exito', '¡Registro completado e inicio de sesión automático realizado con éxito!');
        }

        $mensajeError = $resData['mensaje'] ?? 'Error al procesar el registro con la API.';
        return back()->withErrors(['error' => $mensajeError])->withInput();
    }

    // 2. VISTA Y PROCESO DE INICIO DE SESIÓN
    public function vistaLogin()
    {
        if (session()->has('userToken')) {
            return redirect('/usuario/perfil');
        }
        return view('usuario.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email',
            'contraseña' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = Http::asForm()->post($this->getApiUrl('/cliente/login'), [
            'correo' => $request->correo,
            'contraseña' => $request->contraseña,
        ]);

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            session([
                'userToken' => $resData['token'],
                'cliente' => $resData['cliente']
            ]);

            return redirect('/usuario/perfil')->with('exito', '¡Bienvenido! Sesión iniciada con éxito mediante Token Sanctum.');
        }

        $mensajeError = $resData['mensaje'] ?? 'Correo o contraseña incorrectos.';
        return back()->withErrors(['error' => $mensajeError])->withInput();
    }

    // 3. CIERRE DE SESIÓN (LOGOUT)
    public function logout()
    {
        $this->userClient()->post($this->getApiUrl('/cliente/logout'));

        session()->forget(['userToken', 'cliente']);

        return redirect('/usuario/login')->with('exito', 'Sesión cerrada correctamente. Token revocado.');
    }

    // 4. VER PERFIL
    public function perfil()
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login')->with('error', 'Inicie sesión con Token para acceder a su perfil.');
        }

        $response = $this->userClient()->get($this->getApiUrl('/cliente/perfil'));
        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            $cliente = (object)$resData['cliente'];
            session(['cliente' => $resData['cliente']]);
            return view('usuario.perfil', compact('cliente'));
        }

        // Si el token caducó o es inválido
        session()->forget(['userToken', 'cliente']);
        return redirect('/usuario/login')->with('error', 'Token de sesión expirado. Inicie sesión nuevamente.');
    }

    // 5. ACTUALIZACIÓN DE DATOS GENERALES
    public function actualizarPerfil(Request $request)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login');
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $response = $this->userClient()->asForm()->put($this->getApiUrl('/cliente/perfil'), [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'direccion' => $request->direccion ?? 'Dirección actualizada',
        ]);

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            session(['cliente' => $resData['cliente']]);
            return redirect('/usuario/perfil')->with('exito', 'Datos personales actualizados correctamente vía API con Token.');
        }

        return back()->withErrors(['error' => $resData['mensaje'] ?? 'Error al actualizar perfil.'])->withInput();
    }

    // 6. ACTUALIZACIÓN DE FOTO DE PERFIL
    public function actualizarImagen(Request $request)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login');
        }

        $validator = Validator::make($request->all(), [
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $response = Http::withToken(session('userToken'))
            ->attach(
                'imagen',
                file_get_contents($request->file('imagen')->path()),
                $request->file('imagen')->getClientOriginalName()
            )->post($this->getApiUrl('/cliente/perfil/imagen'));

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            session(['cliente' => $resData['cliente']]);
            return redirect('/usuario/perfil')->with('exito', 'Foto de perfil actualizada exitosamente en la API.');
        }

        return back()->withErrors(['error' => $resData['mensaje'] ?? 'Error al subir la imagen.']);
    }

    // 7. ACTUALIZACIÓN DE CONTRASEÑA
    public function actualizarPassword(Request $request)
    {
        if (!session()->has('userToken')) {
            return redirect('/usuario/login');
        }

        $validator = Validator::make($request->all(), [
            'contraseña_actual' => 'required',
            'nueva_contraseña' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $response = $this->userClient()->asForm()->put($this->getApiUrl('/cliente/perfil/password'), [
            'contraseña_actual' => $request->contraseña_actual,
            'nueva_contraseña' => $request->nueva_contraseña,
        ]);

        $resData = $response->json();

        if ($response->successful() && ($resData['status'] ?? false) === true) {
            return redirect('/usuario/perfil')->with('exito', 'Contraseña actualizada con éxito mediante la API.');
        }

        return back()->withErrors(['error' => $resData['mensaje'] ?? 'La contraseña actual es incorrecta.']);
    }
}
