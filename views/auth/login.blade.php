@extends('plantilla/layout')

@section('contenido')
<div class="max-w-md mx-auto my-12 bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 font-black">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Acceso Administrativo</h2>
        <p class="text-xs text-slate-500 mt-1">Ingrese sus credenciales de administrador para continuar.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 font-bold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle-fill mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Usuario o Correo</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                    <i class="bi bi-person-fill"></i>
                </div>
                <input type="text" name="usuario" value="{{ old('usuario') }}" required class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="Ej. cmendoza">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                    <i class="bi bi-key-fill"></i>
                </div>
                <input type="password" name="contraseña" required class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-5 py-3.5 shadow-md transition-all flex items-center justify-center gap-2">
            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
        </button>
    </form>
</div>
@endsection
