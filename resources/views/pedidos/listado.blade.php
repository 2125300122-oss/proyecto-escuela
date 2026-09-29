@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Pedidos / Ventas</span>
        <h1 class="text-3xl font-black text-blue-900">Historial de Pedidos Realizados</h1>
        <p class="text-sm text-gray-500 mt-1">Registro de ventas y estado de los pedidos de clientes.</p>
    </div>
    <a href="{{ url('/pedidos/formulario') }}" class="text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-cart-plus-fill text-lg"></i> Registrar Nuevo Pedido
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
                <th scope="col" class="px-6 py-4 font-black">Folio / ID</th>
                <th scope="col" class="px-6 py-4 font-black">Imagen Pedido</th>
                <th scope="col" class="px-6 py-4 font-black">Cliente (FK Relacionada)</th>
                <th scope="col" class="px-6 py-4 font-black">Fecha y Hora</th>
                <th scope="col" class="px-6 py-4 font-black">IVA / Desc.</th>
                <th scope="col" class="px-6 py-4 font-black">Monto Total</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Estado del Pedido</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($pedidos as $p)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-900">#{{ $p->id }}</td>
                    <td class="px-6 py-4">
                        <img src="{{ asset('imagenes/pedidos/pedido_' . $p->id . '.png') }}" alt="Pedido" class="w-10 h-10 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name=Pedido+{{ $p->id }}&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4">
                        @if ($p->cliente)
                            <div class="font-bold text-gray-900">{{ $p->cliente->nombres }} {{ $p->cliente->apellidos }}</div>
                            <div class="text-xs text-blue-600">{{ $p->cliente->correo }}</div>
                        @else
                            <span class="text-red-500 italic">Sin cliente asignado</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-700 font-medium">
                        {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 text-xs">
                        <div>IVA: ${{ number_format($p->iva, 2) }}</div>
                        <div class="text-green-600 font-bold">Desc: -${{ number_format($p->descuento, 2) }}</div>
                    </td>
                    <td class="px-6 py-4 font-black text-gray-900 text-base">
                        ${{ number_format($p->total, 2) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 text-xs font-bold rounded-full
                            @if($p->estado == 'Pagado' || $p->estado == 'Entregado') bg-green-100 text-green-800
                            @elseif($p->estado == 'Pendiente') bg-amber-100 text-amber-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $p->estado }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay pedidos registrados en la base de datos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
