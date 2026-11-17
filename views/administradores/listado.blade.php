@extends('plantilla/layout')

@section('contenido')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Listado de Administradores</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/administradores/formulario') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all inline-flex items-center gap-2">
            <i class="bi bi-person-plus-fill"></i> Nuevo Administrador
        </a>
    </div>

    @if (session('exito'))
        <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-800 text-xs font-bold rounded-xl">
            <i class="bi bi-check-circle-fill mr-1"></i> {{ session('exito') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-100 text-xs uppercase font-bold text-slate-700 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Usuario</th>
                    <th class="px-6 py-4">Nombre Completo</th>
                    <th class="px-6 py-4">Correo</th>
                    <th class="px-6 py-4">Rol</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($admins as $a)
                    @php $a = (object)$a; @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">#{{ $a->id }}</td>
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $a->usuario }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $a->nombres }} {{ $a->apellidos }}</td>
                        <td class="px-6 py-4">{{ $a->correo }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-bold bg-purple-50 text-purple-700 rounded-lg border border-purple-100">{{ $a->rol ?? 'Administrador' }}</span></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ url('/administradores/mostrar/' . $a->id) }}" class="text-slate-600 hover:text-blue-600 font-bold text-xs"><i class="bi bi-eye-fill"></i></a>
                            <a href="{{ url('/administradores/editar/' . $a->id) }}" class="text-slate-600 hover:text-amber-600 font-bold text-xs"><i class="bi bi-pencil-square"></i></a>
                            <a href="{{ url('/administradores/borrar/' . $a->id) }}" class="text-slate-600 hover:text-red-600 font-bold text-xs" onclick="return confirm('¿Eliminar administrador?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-slate-400 font-bold">No hay administradores registrados en la API.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
