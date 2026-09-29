@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Detalle de Ventas</span>
        <h1 class="text-3xl font-black text-blue-900">Productos por Pedido (Detalles)</h1>
        <p class="text-sm text-gray-500 mt-1">Desglose de medicamentos incluidos en cada venta o pedido.</p>
    </div>
    <a href="{{ url('/productos_pedidos/formulario') }}" class="text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-plus-square-fill text-lg"></i> Agregar Detalle
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
                <th scope="col" class="px-6 py-4 font-black">ID Reg.</th>
                <th scope="col" class="px-6 py-4 font-black">Imagen Producto</th>
                <th scope="col" class="px-6 py-4 font-black">Pedido (FK Relacionada)</th>
                <th scope="col" class="px-6 py-4 font-black">Producto / Medicamento (FK Relacionada)</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Cantidad</th>
                <th scope="col" class="px-6 py-4 font-black">Precio Unitario</th>
                <th scope="col" class="px-6 py-4 font-black">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($detalles as $d)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">#{{ $d->id }}</td>
                    <td class="px-6 py-4">
                        <img src="{{ asset($d->producto->imagen1 ?? 'imagenes/productos/producto_' . $d->producto_id . '.png') }}" alt="Producto" class="w-10 h-10 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($d->producto->nombre ?? 'Prod') }}&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-black text-blue-900">Pedido #{{ $d->pedido_id }}</div>
                        <div class="text-xs text-gray-500">Cliente: {{ $d->pedido->cliente->nombres ?? 'Sin cliente' }} {{ $d->pedido->cliente->apellidos ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $d->producto->nombre ?? 'Producto no encontrado' }}</div>
                        <div class="text-xs text-gray-500 line-clamp-1">{{ $d->producto->descripcion ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-black rounded-full bg-blue-100 text-blue-800">
                            {{ $d->cantidad }} pzas
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        ${{ number_format($d->precio, 2) }}
                    </td>
                    <td class="px-6 py-4 font-black text-gray-900 text-base">
                        ${{ number_format(($d->precio * $d->cantidad) - $d->descuento, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay detalles de pedidos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
