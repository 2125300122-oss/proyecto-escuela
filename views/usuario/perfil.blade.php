@extends('plantilla/layout')

@section('contenido')
@php $cliente = (object)$cliente; @endphp
<div class="max-w-4xl mx-auto space-y-8">

    <!-- CABECERA DE PERFIL -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-900 rounded-3xl p-6 md:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <img src="{{ str_starts_with($cliente->imagen ?? '', 'http') ? $cliente->imagen : asset($cliente->imagen ?? 'imagenes/clientes/cliente_default.png') }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-white/30 shadow-md" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($cliente->nombres ?? 'Usuario') }}&background=0D8ABC&color=fff'">
            <div>
                <span class="px-2.5 py-0.5 text-[10px] font-extrabold rounded-full bg-emerald-400/20 text-emerald-200 border border-emerald-400/30">
                    <i class="bi bi-shield-check mr-1"></i> Autenticado vía Token Sanctum
                </span>
                <h1 class="text-2xl md:text-3xl font-black mt-1">{{ $cliente->nombres }} {{ $cliente->apellidos }}</h1>
                <p class="text-xs text-blue-200">{{ $cliente->correo }}</p>
            </div>
        </div>

        <a href="{{ url('/usuario/logout') }}" class="text-xs font-bold bg-white/10 hover:bg-white/20 text-white px-4 py-2.5 rounded-xl border border-white/20 transition-all flex items-center gap-1.5">
            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </a>
    </div>

    <!-- MENSAJES DE NOTIFICACIÓN -->
    @if (session('exito'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i> {{ session('exito') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 bg-red-100 border border-red-200 text-red-800 text-xs font-bold rounded-2xl space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle-fill mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- GRID DE FORMULARIOS INDEPENDIENTES PARA EDICIÓN DE PERFIL -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- FORMULARIO 1: DATOS GENERALES -->
        <div class="md:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-md p-6 space-y-4">
            <div class="pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="bi bi-person-lines-fill text-blue-600 text-lg"></i>
                <h2 class="text-base font-black text-slate-900">Actualizar Datos Generales</h2>
            </div>

            <form action="{{ url('/usuario/perfil/actualizar') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombres</label>
                        <input type="text" name="nombres" value="{{ old('nombres', $cliente->nombres) }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Apellidos</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos', $cliente->apellidos) }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl p-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico</label>
                    <input type="email" name="correo" value="{{ old('correo', $cliente->correo) }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl p-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Dirección de Entrega</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $cliente->direccion ?? '') }}" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl p-3">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 rounded-xl shadow-md transition-all">
                    Guardar Cambios Generales
                </button>
            </form>
        </div>

        <!-- COLUMNA DERECHA: FOTO DE PERFIL Y CAMBIO DE CONTRASEÑA -->
        <div class="space-y-6">

            <!-- FORMULARIO 2: IMAGEN DE PERFIL -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-md p-6 space-y-4">
                <div class="pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="bi bi-image-fill text-purple-600 text-lg"></i>
                    <h2 class="text-base font-black text-slate-900">Foto de Perfil</h2>
                </div>

                <form action="{{ url('/usuario/perfil/imagen') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="file" name="imagen" required class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700">
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-md transition-all">
                        Subir Imagen
                    </button>
                </form>
            </div>

            <!-- FORMULARIO 3: CAMBIAR CONTRASEÑA -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-md p-6 space-y-4">
                <div class="pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="bi bi-key-fill text-amber-600 text-lg"></i>
                    <h2 class="text-base font-black text-slate-900">Cambiar Contraseña</h2>
                </div>

                <form action="{{ url('/usuario/perfil/password') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Contraseña Actual</label>
                        <input type="password" name="contraseña_actual" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl p-2.5">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 uppercase mb-1">Nueva Contraseña</label>
                        <input type="password" name="nueva_contraseña" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-xs rounded-xl p-2.5">
                    </div>
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-md transition-all">
                        Actualizar Contraseña
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
