@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Empleados</span>
        <h1 class="text-3xl font-black text-blue-900">Personal de Farmacia Registrado</h1>
        <p class="text-sm text-gray-500 mt-1">Directorio y puestos del personal contratado.</p>
    </div>
    <a href="{{ url('/empleados/formulario') }}" class="text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-person-badge-fill text-lg"></i> Registrar Nuevo Empleado
    </a>
</div>

@if (session('exito'))
    <div class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-200 flex items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
        <span>{{ session('exito') }}</span>
    </div>
@endif

<div class="relative overflow-x-auto shadow-md sm:rounded-2xl border border-gray-100 bg-white">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-blue-900 uppercase bg-blue-50/70 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-black">ID</th>
                <th scope="col" class="px-6 py-4 font-black">Foto</th>
                <th scope="col" class="px-6 py-4 font-black">Nombre Completo</th>
                <th scope="col" class="px-6 py-4 font-black">Correo Electrónico</th>
                <th scope="col" class="px-6 py-4 font-black">Usuario</th>
                <th scope="col" class="px-6 py-4 font-black">Puesto</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($empleados as $emp)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">#{{ $emp->id }}</td>
                    <td class="px-6 py-4">
                        <img src="{{ asset($emp->imagen) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($emp->nombres) }}&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $emp->nombres }} {{ $emp->apellidos }}</td>
                    <td class="px-6 py-4 text-blue-600 font-semibold">{{ $emp->correo }}</td>
                    <td class="px-6 py-4 font-mono text-xs bg-gray-50 px-2 py-1 rounded-md text-gray-700 w-fit">{{ $emp->usuario }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-teal-100 text-teal-800">
                            {{ $emp->puesto }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $emp->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $emp->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay empleados registrados en la base de datos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
