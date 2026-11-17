@extends('plantilla/layout')

@section('contenido')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Listado de Productos</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/productos/formulario') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-md transition-all inline-flex items-center gap-2">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
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
                    <th class="px-6 py-4">Imagen</th>
                    <th class="px-6 py-4">Nombre</th>
                    <th class="px-6 py-4">Categoría</th>
                    <th class="px-6 py-4">Precio</th>
                    <th class="px-6 py-4">Stock</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($productos as $p)
                    @php
                        $p = (object)$p;
                        $cat = is_array($p->categoria ?? null) ? (object)$p->categoria : ($p->categoria ?? null);
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">#{{ $p->id }}</td>
                        <td class="px-6 py-4">
                            <img src="{{ str_starts_with($p->imagen1 ?? '', 'http') ? $p->imagen1 : asset($p->imagen1 ?? 'imagenes/productos/producto_default.png') }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nombre) }}&background=0D8ABC&color=fff'">
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $p->nombre }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-bold bg-blue-50 text-blue-700 rounded-lg border border-blue-100">{{ $cat->nombre ?? 'General' }}</span></td>
                        <td class="px-6 py-4 font-black text-blue-900">${{ number_format($p->precio, 2) }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100">{{ $p->existencia }} Unid.</span></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ url('/productos/mostrar/' . $p->id) }}" class="text-slate-600 hover:text-blue-600 font-bold text-xs"><i class="bi bi-eye-fill"></i></a>
                            <a href="{{ url('/productos/editar/' . $p->id) }}" class="text-slate-600 hover:text-amber-600 font-bold text-xs"><i class="bi bi-pencil-square"></i></a>
                            <a href="{{ url('/productos/borrar/' . $p->id) }}" class="text-slate-600 hover:text-red-600 font-bold text-xs" onclick="return confirm('¿Eliminar producto?')"><i class="bi bi-trash-fill"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-8 text-slate-400 font-bold">No hay productos registrados en la API.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
