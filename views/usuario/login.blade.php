@extends('plantilla/layout')

@section('contenido')
<div class="max-w-md mx-auto my-12 bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 font-black">
            <i class="bi bi-box-arrow-in-right"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Inicio de Sesión de Usuario</h2>
        <p class="text-xs text-slate-500 mt-1">Acceda con su correo para obtener su Token Sanctum</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 font-bold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle-fill mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('exito'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-xs text-green-800 font-bold">
            <i class="bi bi-check-circle-fill mr-1"></i> {{ session('exito') }}
        </div>
    @endif

    <form action="{{ url('/usuario/login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3" placeholder="ejemplo@correo.com">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contraseña</label>
            <input type="password" name="contraseña" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3" placeholder="••••••••">
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-5 py-3.5 shadow-md transition-all flex items-center justify-center gap-2 mt-4">
            <i class="bi bi-shield-check"></i> Iniciar Sesión con Token
        </button>
    </form>

    <div class="mt-6 text-center text-xs text-slate-500">
        ¿No tienes cuenta? <a href="{{ url('/usuario/registro') }}" class="font-bold text-blue-600 hover:underline">Regístrate aquí</a>
    </div>
</div>
@endsection
