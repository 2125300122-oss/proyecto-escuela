<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * POST o GET /api/admin/login
     * Autentica al Administrador y le genera un Token de Sanctum.
     * Soporta Body JSON, Form-Data, Basic Auth y Query Params.
     */
    public function login(Request $request)
    {
        // 1. Obtener usuario y contraseña desde distintas fuentes posibles
        $loginInput = $request->input('usuario')
                      ?? $request->input('user')
                      ?? $request->input('username')
                      ?? $request->getUser();

        $passwordInput = $request->input('contraseña')
                         ?? $request->input('contrasena')
                         ?? $request->input('password')
                         ?? $request->getPassword();

        // Fallback para Query Params formato ?cmendoza=123456
        if (!$loginInput || !$passwordInput) {
            foreach ($request->query() as $key => $val) {
                if (!empty($key) && !empty($val)) {
                    $loginInput = $key;
                    $passwordInput = $val;
                    break;
                }
            }
        }

        if (!$loginInput || !$passwordInput) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Por favor proporcione usuario y contraseña (vía Body JSON, Form-data, Basic Auth o Query Params).'
            ], 422);
        }

        // Buscar por usuario o correo en la tabla administradores
        $admin = Administrador::where(function ($query) use ($loginInput) {
            $query->where('usuario', $loginInput)
                  ->orWhere('correo', $loginInput);
        })->where('estado', 1)->first();

        if (!$admin || !Hash::check($passwordInput, $admin->contraseña)) {
            return response()->json([
                'status' => false,
                'mensaje' => 'Credenciales de administrador inválidas o cuenta inactiva.'
            ], 401);
        }

        // Revocar tokens previos opcionalmente
        $admin->tokens()->delete();

        // Crear token de Sanctum
        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'mensaje' => 'Inicio de sesión exitoso como Administrador',
            'token' => $token,
            'token_type' => 'Bearer',
            'administrador' => $admin
        ], 200);
    }

    /**
     * POST /api/admin/logout
     * Cierra la sesión revocando el token activo del Administrador.
     */
    public function logout(Request $request)
    {
        $admin = $request->user();

        if ($admin && $admin->currentAccessToken()) {
            $admin->currentAccessToken()->delete();
        }

        return response()->json([
            'status' => true,
            'mensaje' => 'Cierre de sesión de administrador exitoso. Token revocado.'
        ], 200);
    }

    /**
     * GET /api/admin/me
     * Retorna los datos del administrador autenticado mediante el token.
     */
    public function me(Request $request)
    {
        return response()->json([
            'status' => true,
            'mensaje' => 'Datos del Administrador autenticado',
            'administrador' => $request->user()
        ], 200);
    }
}
