@extends('plantilla/layout')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 border-b border-gray-100 pb-4 flex items-center justify-between">
        <div>
            <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Clientes</span>
            <h1 class="text-3xl font-black text-blue-900">Formulario de Alta de Cliente</h1>
            <p class="text-sm text-gray-500 mt-1">Registre la información general de los clientes de la farmacia.</p>
        </div>
        <a href="{{ url('/clientes/listado') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-xs px-4 py-2.5 transition-all flex items-center gap-1">
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

    <form action="{{ url('/clientes/guardar') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="nombres" class="block mb-2 text-sm font-bold text-gray-700">Nombres <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-person"></i>
                    </div>
                    <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="Ej. Ana Sofía" required>
                </div>
                @error('nombres')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="apellidos" class="block mb-2 text-sm font-bold text-gray-700">Apellidos <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="Ej. Martínez Fernández" required>
                </div>
                @error('apellidos')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefono" class="block mb-2 text-sm font-bold text-gray-700">Teléfono</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="3331112233">
                </div>
            </div>

            <div>
                <label for="correo" class="block mb-2 text-sm font-bold text-gray-700">Correo Electrónico <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <input type="email" id="correo" name="correo" value="{{ old('correo') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="cliente@correo.com" required>
                </div>
                @error('correo')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="direccion" class="block mb-2 text-sm font-bold text-gray-700">Dirección Completa</label>
            <textarea id="direccion" name="direccion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Av. Hidalgo #123, Col. Centro, Guadalajara, Jal.">{{ old('direccion') }}</textarea>
        </div>

        <div>
            <label class="block mb-2 text-sm font-bold text-gray-700" for="imagen">Fotografía / Identificación (Opcional)</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 p-2.5 focus:outline-none" id="imagen" name="imagen" type="file" accept="image/*">
            @error('imagen')
                <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex items-center gap-4">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-md flex items-center gap-2">
                <i class="bi bi-person-check-fill"></i> Guardar Cliente
            </button>
            <button type="reset" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-6 py-3 transition-all">
                Limpiar
            </button>
        </div>
    </form>
</div>
@endsection
