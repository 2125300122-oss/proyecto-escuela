@extends('plantilla/layout')

@section('contenido')
@php $marca = (object)$marca; @endphp
<div class="max-w-xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Detalle de Marca / Proveedor</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/marcas/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="space-y-4">
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">ID Marca</span>
            <span class="text-base font-black text-slate-900">#{{ $marca->id }}</span>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">Nombre de Marca / Laboratorio</span>
            <span class="text-xl font-black text-blue-900">{{ $marca->nombre }}</span>
        </div>
    </div>
</div>
@endsection
