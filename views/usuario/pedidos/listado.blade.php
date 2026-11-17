@extends('plantilla/layout')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 flex items-center gap-2">
                <i class="bi bi-bag-check-fill text-blue-600"></i> Mis Pedidos
            </h1>
            <p class="text-xs text-slate-500 mt-1">Historial de pedidos realizados consumiendo la API REST con Token Sanctum</p>
        </div>
        <a href="{{ url('/catalogo') }}" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-xl shadow-md transition-all">
            <i class="bi bi-plus-lg"></i> Realizar Nuevo Pedido
        </a>
    </div>

    <!-- MENSAJES DE NOTIFICACIÓN -->
    @if (session('exito'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-800 text-xs font-bold rounded-xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i> {{ session('exito') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 bg-red-100 border border-red-200 text-red-800 text-xs font-bold rounded-xl flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-base"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase font-bold text-slate-700 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Número de Pedido</th>
                        <th class="px-6 py-4">Fecha</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pedidos as $p)
                        @php
                            $p = (object)$p;
                            $esCancelado = strtolower($p->estado ?? '') === 'cancelado';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-black text-slate-900">#{{ $p->id }}</td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">
                                {{ isset($p->fecha) ? date('Y-m-d H:i', strtotime($p->fecha)) : date('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($esCancelado)
                                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        <i class="bi bi-x-circle-fill mr-1"></i> Cancelado
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="bi bi-check-circle-fill mr-1"></i> {{ $p->estado ?? 'Pagado' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-black text-blue-900 text-base">
                                ${{ number_format($p->total ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ url('/usuario/pedidos/' . $p->id) }}" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-lg transition-all inline-flex items-center gap-1">
                                    <i class="bi bi-eye-fill"></i> Ver Detalle
                                </a>

                                @if (!$esCancelado)
                                    <a href="{{ url('/usuario/pedidos/cancelar/' . $p->id) }}" onclick="return confirm('¿Está seguro de cancelar el Pedido #{{ $p->id }}? Las existencias serán devueltas a la base de datos.')" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-3 py-1.5 rounded-lg transition-all inline-flex items-center gap-1">
                                        <i class="bi bi-x-square-fill"></i> Cancelar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400 font-bold">
                                <i class="bi bi-inbox text-4xl block mb-2"></i>
                                No has realizado ningún pedido aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
