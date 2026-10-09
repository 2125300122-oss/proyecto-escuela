@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Marcas / Laboratorios</span>
        <h1 class="text-3xl font-black text-blue-900">Marcas y Laboratorios Registrados</h1>
        <p class="text-sm text-gray-500 mt-1">Catálogo de laboratorios farmacéuticos y marcas de productos.</p>
    </div>
    <a href="{{ url('/marcas/formulario') }}" class="text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-tag-fill text-lg"></i> Registrar Nueva Marca
    </a>
</div>

@if (session('exito'))
    <div class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-200 flex items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
        <span>{{ session('exito') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-200 flex items-center gap-2" role="alert">
        <i class="bi bi-exclamation-triangle-fill text-red-600 text-lg"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-2xl border border-gray-100 bg-white">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-blue-900 uppercase bg-blue-50/70 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-black">Logotipo</th>
                <th scope="col" class="px-6 py-4 font-black">ID</th>
                <th scope="col" class="px-6 py-4 font-black">Laboratorio / Marca</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Estado</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Acciones CRUD</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($marcas as $m)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <img src="{{ asset($m->imagen) }}" alt="Logo" class="w-10 h-10 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($m->nombre) }}&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">#{{ $m->id }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $m->nombre }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $m->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $m->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ url('/marcas/mostrar/' . $m->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-all">
                                <i class="bi bi-eye-fill"></i> Ver
                            </a>
                            <a href="{{ url('/marcas/editar/' . $m->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg border border-amber-200 transition-all">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <a href="{{ url('/marcas/borrar/' . $m->id) }}" onclick="return confirm('¿Eliminar marca?')" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg border border-red-200 transition-all">
                                <i class="bi bi-trash-fill"></i> Borrar
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay marcas registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
