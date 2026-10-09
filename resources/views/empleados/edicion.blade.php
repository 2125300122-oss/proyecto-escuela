@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Edición de Registro</span>
        <h1 class="text-3xl font-black text-blue-900">Editar Empleado #{{ $empleado->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Modifica los datos del personal e invoca la actualización validada en el controlador.</p>
    </div>
    <a href="{{ url('/empleados/listado') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center justify-center gap-2">
        <i class="bi bi-arrow-left"></i> Volver al Listado
    </a>
</div>

@if ($errors->any())
    <div class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-200" role="alert">
        <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill mr-1"></i> Por favor corrige los siguientes errores:</div>
        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('/empleados/actualizar/' . $empleado->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">

        <!-- NOMBRES -->
        <div>
            <label for="nombres" class="block mb-2 text-sm font-bold text-gray-900">Nombres *</label>
            <input type="text" id="nombres" name="nombres" value="{{ old('nombres', $empleado->nombres) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- APELLIDOS -->
        <div>
            <label for="apellidos" class="block mb-2 text-sm font-bold text-gray-900">Apellidos *</label>
            <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos', $empleado->apellidos) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- CORREO -->
        <div>
            <label for="correo" class="block mb-2 text-sm font-bold text-gray-900">Correo Electrónico *</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo', $empleado->correo) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- USUARIO -->
        <div>
            <label for="usuario" class="block mb-2 text-sm font-bold text-gray-900">Usuario de Sistema *</label>
            <input type="text" id="usuario" name="usuario" value="{{ old('usuario', $empleado->usuario) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- PUESTO -->
        <div class="md:col-span-2">
            <label for="puesto" class="block mb-2 text-sm font-bold text-gray-900">Puesto / Cargo *</label>
            <input type="text" id="puesto" name="puesto" value="{{ old('puesto', $empleado->puesto) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- IMAGEN -->
        <div class="md:col-span-2">
            <label for="imagen" class="block mb-2 text-sm font-bold text-gray-900">Actualizar Fotografía (Opcional)</label>
            <div class="flex items-center gap-4">
                <img src="{{ asset($empleado->imagen) }}" alt="Foto Actual" class="w-14 h-14 rounded-full object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($empleado->nombres) }}&background=0D8ABC&color=fff'">
                <input type="file" id="imagen" name="imagen" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-white p-2 shadow-sm">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-4">
        <a href="{{ url('/empleados/listado') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Cancelar</a>
        <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md transition-all flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> Guardar Cambios
        </button>
    </div>
</form>
@endsection
