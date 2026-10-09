@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Productos / Medicamentos</span>
        <h1 class="text-3xl font-black text-blue-900">Catálogo de Medicamentos e Inventario</h1>
        <p class="text-sm text-gray-500 mt-1">Consulta e inventario general de medicamentos y productos farmacéuticos.</p>
    </div>
    <a href="{{ url('/productos/formulario') }}" class="text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-capsule text-lg"></i> Agregar Nuevo Producto
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
                <th scope="col" class="px-6 py-4 font-black">ID</th>
                <th scope="col" class="px-6 py-4 font-black">Imagen</th>
                <th scope="col" class="px-6 py-4 font-black">Medicamento / Producto</th>
                <th scope="col" class="px-6 py-4 font-black">Categoría</th>
                <th scope="col" class="px-6 py-4 font-black">Tipo</th>
                <th scope="col" class="px-6 py-4 font-black">Marca</th>
                <th scope="col" class="px-6 py-4 font-black">Precio / Descuento</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Stock</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Acciones CRUD</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($productos as $p)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">#{{ $p->id }}</td>
                    <td class="px-6 py-4">
                        <img src="{{ asset($p->imagen1) }}" alt="Foto" class="w-12 h-12 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nombre) }}&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-base">{{ $p->nombre }}</div>
                        <div class="text-xs text-gray-500 line-clamp-1">{{ $p->descripcion }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-blue-100 text-blue-800">
                            {{ $p->categoria->nombre ?? 'Sin categoría' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-purple-100 text-purple-800">
                            {{ $p->tipo->nombre ?? 'Sin tipo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-amber-100 text-amber-800">
                            {{ $p->marca->nombre ?? 'Sin marca' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-black text-gray-900">${{ number_format($p->precio, 2) }}</div>
                        @if ($p->descuento > 0)
                            <div class="text-xs text-green-600 font-bold">Desc: -${{ number_format($p->descuento, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-extrabold rounded-full {{ $p->existencia > 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $p->existencia }} uds.
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-1.5">
                            <!-- ACCIÓN MOSTRAR -->
                            <a href="{{ url('/productos/mostrar/' . $p->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-all" title="Ver Detalles">
                                <i class="bi bi-eye-fill"></i> Ver
                            </a>
                            <!-- ACCIÓN EDITAR -->
                            <a href="{{ url('/productos/editar/' . $p->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg border border-amber-200 transition-all" title="Editar Registro">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <!-- ACCIÓN BORRAR -->
                            <a href="{{ url('/productos/borrar/' . $p->id) }}" onclick="return confirm('¿Seguro que deseas eliminar este producto?')" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg border border-red-200 transition-all" title="Eliminar Registro">
                                <i class="bi bi-trash-fill"></i> Borrar
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay productos registrados en la base de datos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
