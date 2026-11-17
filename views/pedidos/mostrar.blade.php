@extends('plantilla/layout')

@section('contenido')
@php
    $pedido = (object)$pedido;
    $cli = is_array($pedido->cliente ?? null) ? (object)$pedido->cliente : ($pedido->cliente ?? null);
@endphp
<div class="max-w-xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Consulta de Pedido #{{ $pedido->id }}</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/pedidos/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>

    <div class="space-y-4">
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">Cliente</span>
            <span class="text-lg font-black text-slate-900">{{ $cli->nombres ?? 'Cliente' }} {{ $cli->apellidos ?? '' }}</span>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">Fecha</span>
                <span class="text-sm font-black text-slate-900">{{ $pedido->fecha ?? date('Y-m-d') }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">Estado</span>
                <span class="text-sm font-black text-emerald-700">{{ $pedido->estado ?? 'Pagado' }}</span>
            </div>
        </div>

        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
            <span class="text-xs text-blue-600 font-bold uppercase block">Monto Total del Pedido</span>
            <span class="text-2xl font-black text-blue-900">${{ number_format($pedido->total ?? 0, 2) }} <span class="text-xs font-normal">MXN</span></span>
        </div>
    </div>
</div>
@endsection
