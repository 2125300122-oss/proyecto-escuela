@extends('plantilla/layout')

@section('contenido')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900">Listado de Pedidos</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
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
                    <th class="px-6 py-4">ID Pedido</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4">Fecha</th>
                    <th class="px-6 py-4">Monto Total</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($pedidos as $p)
                    @php
                        $p = (object)$p;
                        $cli = is_array($p->cliente ?? null) ? (object)$p->cliente : ($p->cliente ?? null);
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">#{{ $p->id }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $cli->nombres ?? 'Cliente' }} {{ $cli->apellidos ?? '' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $p->fecha ?? date('Y-m-d') }}</td>
                        <td class="px-6 py-4 font-black text-blue-900">${{ number_format($p->total ?? 0, 2) }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100">{{ $p->estado ?? 'Pagado' }}</span></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ url('/pedidos/mostrar/' . $p->id) }}" class="text-slate-600 hover:text-blue-600 font-bold text-xs"><i class="bi bi-eye-fill"></i> Consultar</a>
                            <a href="{{ url('/pedidos/borrar/' . $p->id) }}" class="text-slate-600 hover:text-red-600 font-bold text-xs" onclick="return confirm('¿Eliminar pedido?')"><i class="bi bi-trash-fill"></i> Borrar</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-8 text-slate-400 font-bold">No hay pedidos registrados en la API.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
