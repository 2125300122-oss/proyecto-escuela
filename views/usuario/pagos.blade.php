@extends('plantilla/layout')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 flex items-center gap-2">
                <i class="bi bi-credit-card-2-front-fill text-emerald-600"></i> Estado de Pagos Realizados
            </h1>
            <p class="text-xs text-slate-500 mt-1">Historial de transacciones aprobadas vía Pasarela PayPal Sandbox registradas en la API</p>
        </div>
        <a href="{{ url('/usuario/pedidos') }}" class="text-xs font-bold text-slate-700 bg-slate-200/60 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition-all">
            <i class="bi bi-bag-check-fill"></i> Ver Todos Mis Pedidos
        </a>
    </div>

    <!-- MENSAJES DE NOTIFICACIÓN -->
    @if (session('exito'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-800 text-xs font-bold rounded-xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i> {{ session('exito') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-xs uppercase font-bold text-slate-700 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Código de Transacción</th>
                        <th class="px-6 py-4">Pedido</th>
                        <th class="px-6 py-4">Método de Pago</th>
                        <th class="px-6 py-4">Fecha Transacción</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Monto Pagado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pagos as $p)
                        @php $p = (object)$p; @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- CÓDIGO DE TRANSACCIÓN -->
                            <td class="px-6 py-4">
                                <span class="font-mono font-black text-slate-900 text-xs bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                                    {{ $p->codigo_transaccion ?? 'PAYPAL-SANDBOX-TX-98472' }}
                                </span>
                            </td>

                            <!-- PEDIDO -->
                            <td class="px-6 py-4 font-bold text-slate-800">
                                #{{ $p->id }}
                            </td>

                            <!-- MÉTODO -->
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-200 inline-flex items-center gap-1">
                                    <i class="bi bi-paypal"></i> {{ $p->metodo_pago ?? 'PayPal Sandbox' }}
                                </span>
                            </td>

                            <!-- FECHA -->
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">
                                {{ isset($p->fecha_pago) ? date('Y-m-d H:i', strtotime($p->fecha_pago)) : (isset($p->fecha) ? date('Y-m-d H:i', strtotime($p->fecha)) : date('Y-m-d H:i')) }}
                            </td>

                            <!-- ESTADO -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1">
                                    <i class="bi bi-shield-check"></i> {{ $p->estado ?? 'Aprobado via PayPal Sandbox' }}
                                </span>
                            </td>

                            <!-- MONTO -->
                            <td class="px-6 py-4 font-black text-blue-900 text-base">
                                ${{ number_format($p->total ?? 0, 2) }}
                            </td>

                            <!-- ACCIONES -->
                            <td class="px-6 py-4 text-center">
                                <a href="{{ url('/usuario/pedidos/' . $p->id) }}" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1.5 rounded-lg transition-all inline-flex items-center gap-1">
                                    <i class="bi bi-eye-fill"></i> Ver Recibo
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-slate-400 font-bold">
                                <i class="bi bi-credit-card text-4xl block mb-2"></i>
                                No hay transacciones de pago registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
