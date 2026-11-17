@extends('plantilla/layout')

@section('contenido')
<div class="max-w-md mx-auto my-8 bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 font-black">
            <i class="bi bi-person-plus-fill"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Registro de Usuario</h2>
        <p class="text-xs text-slate-500 mt-1">Crea tu cuenta para gestionar tu perfil vía API REST</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 font-bold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle-fill mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/usuario/registro') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombres</label>
                <input type="text" name="nombres" value="{{ old('nombres') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Apellidos</label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3" placeholder="ejemplo@correo.com">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contraseña</label>
            <input type="password" name="contraseña" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3" placeholder="Mínimo 6 caracteres">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Dirección de Entrega</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3" placeholder="Calle, Número, Colonia">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Foto de Perfil (Opcional)</label>
            <input type="file" name="imagen" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-5 py-3.5 shadow-md transition-all flex items-center justify-center gap-2 mt-4">
            <i class="bi bi-check-circle-fill"></i> Crear Cuenta & Obtener Token
        </button>
    </form>

    <div class="mt-6 text-center text-xs text-slate-500">
        ¿Ya tienes cuenta? <a href="{{ url('/usuario/login') }}" class="font-bold text-blue-600 hover:underline">Inicia Sesión aquí</a>
    </div>
</div>
@endsection
