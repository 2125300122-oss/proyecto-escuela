<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleController extends Controller
{
    /**
     * Muestra la vista de Inicio de Sesión.
     */
    public function showLoginForm()
    {
        return view('auth/login');
    }

    /**
     * Redirige al usuario a la página de autenticación de Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta del callback de Google tras la autenticación.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(rand(100000, 999999)),
                ]);
            }

            Auth::login($user);

            return redirect('/inicio')->with('exito', '¡Bienvenido ' . $user->name . '! Sesión iniciada con Google correctamente.');
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Ocurrió un detalle al conectar con Google: ' . $e->getMessage());
        }
    }

    /**
     * Cierra la sesión activa del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('exito', 'Sesión cerrada correctamente.');
    }
}
