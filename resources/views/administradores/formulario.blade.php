@extends('plantilla/layout')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 border-b border-gray-100 pb-4 flex items-center justify-between">
        <div>
            <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Administradores</span>
            <h1 class="text-3xl font-black text-blue-900">Formulario de Registro de Administrador</h1>
            <p class="text-sm text-gray-500 mt-1">Registre nuevos administradores para la gestión de la plataforma.</p>
        </div>
        <a href="{{ url('/administradores/listado') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-xs px-4 py-2.5 transition-all flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-200">
            <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Por favor corrija los siguientes errores:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form-administrador" action="{{ url('/administradores/guardar') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="imagen">Foto de Perfil</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 p-2.5" id="imagen" name="imagen" type="file" accept="image/*">
                @error('imagen')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombres" class="block mb-2 text-sm font-bold text-gray-700">Nombres <span class="text-red-500">*</span></label>
                <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Ej. Juan Carlos" required>
                @error('nombres')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="apellidos" class="block mb-2 text-sm font-bold text-gray-700">Apellidos <span class="text-red-500">*</span></label>
                <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Ej. Pérez García" required>
                @error('apellidos')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="correo" class="block mb-2 text-sm font-bold text-gray-700">Correo Electrónico <span class="text-red-500">*</span></label>
                <input type="email" id="correo" name="correo" value="{{ old('correo') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="admin@farmacia.com" required>
                @error('correo')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="usuario" class="block mb-2 text-sm font-bold text-gray-700">Nombre de Usuario <span class="text-red-500">*</span></label>
                <input type="text" id="usuario" name="usuario" value="{{ old('usuario') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="jlopez_admin" required>
                @error('usuario')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="contraseña" class="block mb-2 text-sm font-bold text-gray-700">Contraseña <span class="text-red-500">*</span></label>
                <input type="password" id="contraseña" name="contraseña" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="••••••••" required>
                @error('contraseña')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rol" class="block mb-2 text-sm font-bold text-gray-700">Rol o Puesto</label>
                <select id="rol" name="rol" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                    <option value="Administrador" {{ old('rol') == 'Administrador' ? 'selected' : '' }}>Administrador General</option>
                    <option value="Gerente" {{ old('rol') == 'Gerente' ? 'selected' : '' }}>Gerente</option>
                    <option value="Farmacéutico" {{ old('rol') == 'Farmacéutico' ? 'selected' : '' }}>Farmacéutico</option>
                </select>
            </div>
        </div>

        <div class="pt-4 flex items-center gap-4">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-md flex items-center gap-2">
                <i class="bi bi-shield-check"></i> Guardar Administrador
            </button>
            <button type="reset" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-6 py-3 transition-all">
                Limpiar
            </button>
        </div>
    </form>
</div>
@endsection
