@extends('plantilla/layout')

@section('contenido')
<div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Administradores</span>
        <h2 class="text-3xl font-black text-blue-900">Administradores Registrados</h2>
        <p class="text-sm text-gray-500 mt-1">Consulta el personal con acceso a la gestión de la tienda.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ url('/administradores/formulario') }}" class="inline-flex items-center justify-center px-5 py-3 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md transition-all gap-2">
            <i class="bi bi-person-plus-fill"></i> Nuevo Administrador
        </a>
    </div>
</div>

@if (session('exito'))
    <div class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-200 flex items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
        <span>{{ session('exito') }}</span>
    </div>
@endif

<div class="relative overflow-x-auto border border-gray-100 rounded-2xl shadow-md bg-white">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-blue-900 uppercase bg-blue-50/70 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-black">ID</th>
                <th scope="col" class="px-6 py-4 font-black">Foto</th>
                <th scope="col" class="px-6 py-4 font-black">Nombres</th>
                <th scope="col" class="px-6 py-4 font-black">Apellidos</th>
                <th scope="col" class="px-6 py-4 font-black">Correo</th>
                <th scope="col" class="px-6 py-4 font-black">Usuario</th>
                <th scope="col" class="px-6 py-4 font-black">Rol</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($admins as $admin)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">#{{ $admin->id }}</td>
                    <td class="px-6 py-4">
                        <img src="{{ asset($admin->imagen) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($admin->nombres) }}&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $admin->nombres }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $admin->apellidos }}</td>
                    <td class="px-6 py-4 text-blue-600 font-semibold">{{ $admin->correo }}</td>
                    <td class="px-6 py-4 font-mono text-xs bg-gray-50 px-2 py-1 rounded-md text-gray-700 w-fit">{{ $admin->usuario }}</td>
                    <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">{{ $admin->rol }}</span></td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full {{ $admin->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $admin->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay administradores registrados en la base de datos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
