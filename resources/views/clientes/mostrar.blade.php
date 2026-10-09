@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Ficha Detallada (Solo Lectura)</span>
        <h1 class="text-3xl font-black text-blue-900">Cliente #{{ $cliente->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Consulta la información del cliente registrado en la base de datos.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ url('/clientes/editar/' . $cliente->id) }}" class="text-white bg-amber-600 hover:bg-amber-700 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-pencil-square"></i> Editar Cliente
        </a>
        <a href="{{ url('/clientes/listado') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-50/50 p-6 md:p-8 rounded-3xl border border-gray-100">

    <!-- FOTOGRAFÍA -->
    <div class="flex flex-col items-center justify-center bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
        <img src="{{ asset($cliente->imagen) }}" alt="Fotografía del Cliente" class="w-40 h-40 object-cover rounded-full border border-gray-200 shadow-md mb-4" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($cliente->nombres) }}&background=0D8ABC&color=fff'">
        <span class="text-xs text-gray-400 font-mono">Imagen por ID: cliente_{{ $cliente->id }}.png</span>
    </div>

    <!-- INFORMACIÓN (SOLO LECTURA) -->
    <div class="md:col-span-2 space-y-6">

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nombre Completo</span>
                <div class="text-2xl font-black text-blue-900">{{ $cliente->nombres }} {{ $cliente->apellidos }}</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Correo Electrónico</span>
                    <span class="text-blue-600 font-bold text-base">{{ $cliente->correo }}</span>
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Estado de Cuenta</span>
                    <span class="inline-block px-3 py-1 text-xs font-extrabold rounded-full {{ $cliente->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $cliente->estado ? 'Cuenta Activa' : 'Inactivo' }}
                    </span>
                </div>
            </div>

            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Dirección de Envío</span>
                <p class="text-gray-700 text-sm leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $cliente->direccion }}</p>
            </div>
        </div>

    </div>
</div>
@endsection
