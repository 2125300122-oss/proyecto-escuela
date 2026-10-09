@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Ficha Detallada (Solo Lectura)</span>
        <h1 class="text-3xl font-black text-blue-900">Empleado #{{ $empleado->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Consulta la información del personal contratado.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ url('/empleados/editar/' . $empleado->id) }}" class="text-white bg-amber-600 hover:bg-amber-700 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-pencil-square"></i> Editar Empleado
        </a>
        <a href="{{ url('/empleados/listado') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-50/50 p-6 md:p-8 rounded-3xl border border-gray-100">

    <div class="flex flex-col items-center justify-center bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
        <img src="{{ asset($empleado->imagen) }}" alt="Fotografía del Empleado" class="w-40 h-40 object-cover rounded-full border border-gray-200 shadow-md mb-4" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($empleado->nombres) }}&background=0D8ABC&color=fff'">
        <span class="text-xs text-gray-400 font-mono">Imagen por ID: empleado_{{ $empleado->id }}.png</span>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nombre Completo</span>
                <div class="text-2xl font-black text-blue-900">{{ $empleado->nombres }} {{ $empleado->apellidos }}</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Correo Electrónico</span>
                    <span class="text-blue-600 font-bold text-base">{{ $empleado->correo }}</span>
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Usuario de Sistema</span>
                    <span class="font-mono text-xs bg-gray-100 px-3 py-1.5 rounded-lg text-gray-800 font-bold block w-fit">{{ $empleado->usuario }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Puesto / Cargo</span>
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-lg bg-teal-100 text-teal-800">
                        {{ $empleado->puesto }}
                    </span>
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Estatus en Sistema</span>
                    <span class="inline-block px-3 py-1 text-xs font-extrabold rounded-full {{ $empleado->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $empleado->estado ? 'Empleado Activo' : 'Inactivo' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
