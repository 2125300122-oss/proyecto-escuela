@extends('plantilla/layout')

@section('contenido')
<div class="max-w-md mx-auto my-8 p-8 bg-white rounded-3xl shadow-xl border border-gray-100 ring-1 ring-gray-900/5">
    <div class="text-center mb-8">
        <div class="inline-flex p-3 bg-blue-50 text-blue-600 rounded-2xl mb-3">
            <i class="bi bi-shield-lock-fill text-3xl"></i>
        </div>
        <h1 class="text-2xl font-black text-blue-900">Iniciar Sesión</h1>
        <p class="text-xs text-gray-500 mt-1">Acceda al Panel Administrativo de la Farmacia</p>
    </div>

    @if (session('error'))
        <div class="p-4 mb-6 text-xs text-red-800 rounded-2xl bg-red-50 border border-red-200 flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-red-600 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if (session('exito'))
        <div class="p-4 mb-6 text-xs text-green-800 rounded-2xl bg-green-50 border border-green-200 flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-green-600 text-base"></i>
            <span>{{ session('exito') }}</span>
        </div>
    @endif

    <!-- BOTÓN DE INICIO DE SESIÓN CON GOOGLE -->
    <div class="space-y-4">
        <a href="{{ url('/auth/google') }}" class="w-full flex items-center justify-center gap-3 bg-white hover:bg-gray-50 text-gray-700 font-bold border border-gray-300 rounded-2xl px-5 py-3.5 shadow-sm transition-all text-sm group">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span>Iniciar Sesión con Google</span>
        </a>

        <div class="relative flex py-2 items-center">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink mx-4 text-xs text-gray-400 font-semibold">o con cuenta local</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <form action="#" method="POST" class="space-y-4">
            <div>
                <label for="correo" class="block mb-2 text-xs font-bold text-gray-700">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="usuario@correo.com">
            </div>

            <div>
                <label for="password" class="block mb-2 text-xs font-bold text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="••••••••">
            </div>

            <button type="button" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-xs px-5 py-3 transition-all shadow-md">
                Ingresar al Sistema
            </button>
        </form>
    </div>
</div>
@endsection
