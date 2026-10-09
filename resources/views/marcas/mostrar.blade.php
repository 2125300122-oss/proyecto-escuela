@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Ficha Detallada (Solo Lectura)</span>
        <h1 class="text-3xl font-black text-blue-900">Marca / Laboratorio #{{ $marca->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Consulta los detalles del laboratorio registrado.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ url('/marcas/editar/' . $marca->id) }}" class="text-white bg-amber-600 hover:bg-amber-700 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-pencil-square"></i> Editar Marca
        </a>
        <a href="{{ url('/marcas/listado') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-50/50 p-6 md:p-8 rounded-3xl border border-gray-100">
    <div class="flex flex-col items-center justify-center bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
        <img src="{{ asset($marca->imagen) }}" alt="Logotipo de Marca" class="w-40 h-40 object-cover rounded-2xl border border-gray-200 shadow-md mb-4" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($marca->nombre) }}&background=0D8ABC&color=fff'">
        <span class="text-xs text-gray-400 font-mono">Logotipo por ID: marca_{{ $marca->id }}.png</span>
    </div>

    <div class="md:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nombre del Laboratorio / Marca</span>
                <div class="text-2xl font-black text-blue-900">{{ $marca->nombre }}</div>
            </div>

            <div>
                <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Estatus en Sistema</span>
                <span class="inline-block px-3 py-1 text-xs font-extrabold rounded-full {{ $marca->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $marca->estado ? 'Laboratorio Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
