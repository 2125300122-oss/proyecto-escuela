@extends('plantilla/layout')

@section('contenido')
@php
    $pedido = (object)$pedido;
    $detalles = $pedido->productos_pedido ?? [];
    $esCancelado = strtolower($pedido->estado ?? '') === 'cancelado';
@endphp
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ url('/usuario/pedidos') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 bg-slate-200/60 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver a Mis Pedidos
        </a>

        @if (!$esCancelado)
            <a href="{{ url('/usuario/pedidos/cancelar/' . $pedido->id) }}" onclick="return confirm('¿Está seguro de cancelar este pedido? Se restaurarán las existencias.')" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                <i class="bi bi-x-circle-fill"></i> Cancelar Pedido #{{ $pedido->id }}
            </a>
        @endif
    </div>

    <!-- MENSAJES DE NOTIFICACIÓN -->
    @if (session('exito'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-800 text-xs font-bold rounded-2xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i> {{ session('exito') }}
        </div>
    @endif

    <!-- TARJETA CABECERA DEL PEDIDO -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase block">Pedido Consultado vía API Sanctum Token</span>
                <h1 class="text-3xl font-black text-slate-900">Pedido #{{ $pedido->id }}</h1>
                <p class="text-xs text-slate-500 mt-1">Fecha de creación: {{ date('Y-m-d H:i:s', strtotime($pedido->fecha ?? now())) }}</p>
            </div>

            <div>
                @if ($esCancelado)
                    <span class="px-4 py-2 text-xs font-black rounded-full bg-red-100 text-red-800 border border-red-200 inline-flex items-center gap-1.5">
                        <i class="bi bi-x-circle-fill"></i> Estado: CANCELADO
                    </span>
                @else
                    <span class="px-4 py-2 text-xs font-black rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200 inline-flex items-center gap-1.5">
                        <i class="bi bi-check-circle-fill"></i> Estado: {{ strtoupper($pedido->estado ?? 'PAGADO VIA PAYPAL') }}
                    </span>
                @endif
            </div>
        </div>

        <!-- INFORMACIÓN DE LA TRANSACCIÓN DE PAGO PAYPAL SANDBOX -->
        <div class="bg-amber-50/70 p-6 rounded-2xl border border-amber-200/80 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="bi bi-paypal text-blue-600 text-base"></i> Detalles del Pago vía Pasarela (PayPal Sandbox)
                </span>
                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full bg-emerald-200 text-emerald-900">
                    Aprobado (Sandbox)
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-amber-200/50 text-xs">
                <div>
                    <span class="text-slate-500 font-bold block">Código de Transacción:</span>
                    <span class="font-mono font-black text-slate-900 bg-white px-2 py-1 rounded border border-amber-300 inline-block mt-0.5">
                        {{ $pedido->codigo_transaccion ?? 'PAYPAL-SANDBOX-TX-' . strtoupper(substr(md5($pedido->id ?? 1), 0, 10)) }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-500 font-bold block">Método de Pago:</span>
                    <span class="font-bold text-slate-800 mt-0.5 block">
                        {{ $pedido->metodo_pago ?? 'PayPal Sandbox REST API' }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-500 font-bold block">Fecha del Pago:</span>
                    <span class="font-bold text-slate-800 mt-0.5 block">
                        {{ isset($pedido->fecha_pago) ? date('Y-m-d H:i:s', strtotime($pedido->fecha_pago)) : date('Y-m-d H:i:s', strtotime($pedido->fecha ?? now())) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- LISTA DE PRODUCTOS INCLUIDOS EN EL PEDIDO -->
        <div class="space-y-4">
            <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Productos Incluidos en la Orden</h3>

            <div class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-100">
                @foreach ($detalles as $d)
                    @php
                        $d = (object)$d;
                        $prod = is_array($d->producto ?? null) ? (object)$d->producto : ($d->producto ?? null);
                        $subtotal = ($d->precio ?? 0) * ($d->cantidad ?? 1);
                    @endphp
                    <div class="p-4 flex items-center justify-between gap-4 hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <img src="{{ $prod->imagen1 ?? 'https://ui-avatars.com/api/?name=' . urlencode($prod->nombre ?? 'Producto') }}" class="w-14 h-14 object-contain rounded-xl border border-slate-200 p-1" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($prod->nombre ?? 'P') }}&background=0D8ABC&color=fff'">
                            <div>
                                <span class="font-bold text-slate-900 text-sm block">{{ $prod->nombre ?? 'Producto de la API' }}</span>
                                <span class="text-xs text-slate-400 font-medium">Precio Unitario: ${{ number_format($d->precio ?? 0, 2) }}</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <span class="text-xs font-bold text-slate-500 block">Cantidad: <strong class="text-slate-900 font-black">{{ $d->cantidad }}</strong></span>
                            <span class="text-base font-black text-blue-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TOTAL DE COMPRA -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-bold uppercase block">Impuesto IVA (16%)</span>
                <span class="text-sm font-bold text-slate-700">${{ number_format($pedido->iva ?? 0, 2) }}</span>
            </div>

            <div class="text-right">
                <span class="text-xs text-blue-600 font-bold uppercase block">Total Pagado vía Pasarela</span>
                <span class="text-3xl font-black text-blue-900">${{ number_format($pedido->total ?? 0, 2) }} <span class="text-xs font-normal text-slate-400">MXN</span></span>
            </div>
        </div>
    </div>
</div>
@endsection
