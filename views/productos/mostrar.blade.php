@extends('plantilla/layout')

@section('contenido')
@php
    $producto = (object)$producto;
    $cat = is_array($producto->categoria ?? null) ? (object)$producto->categoria : ($producto->categoria ?? null);
    $mar = is_array($producto->marca ?? null) ? (object)$producto->marca : ($producto->marca ?? null);
    $tip = is_array($producto->tipo ?? null) ? (object)$producto->tipo : ($producto->tipo ?? null);
@endphp
<div class="max-w-xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Detalle del Producto</h1>
            <p class="text-xs text-slate-500 mt-1">Información leída desde la API REST</p>
        </div>
        <a href="{{ url('/productos/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>

    <div class="space-y-4">
        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <img src="{{ str_starts_with($producto->imagen1 ?? '', 'http') ? $producto->imagen1 : asset($producto->imagen1 ?? 'imagenes/productos/producto_default.png') }}" class="w-20 h-20 rounded-2xl object-cover border border-slate-200" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($producto->nombre) }}&background=0D8ABC&color=fff'">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase block">Producto #{{ $producto->id }}</span>
                <span class="text-xl font-black text-slate-900">{{ $producto->nombre }}</span>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="bg-blue-50 p-3 rounded-2xl border border-blue-100">
                <span class="text-[10px] text-blue-600 font-bold uppercase block">Categoría</span>
                <span class="text-xs font-black text-blue-900">{{ $cat->nombre ?? 'General' }}</span>
            </div>
            <div class="bg-purple-50 p-3 rounded-2xl border border-purple-100">
                <span class="text-[10px] text-purple-600 font-bold uppercase block">Laboratorio</span>
                <span class="text-xs font-black text-purple-900">{{ $mar->nombre ?? 'Farmacia' }}</span>
            </div>
            <div class="bg-amber-50 p-3 rounded-2xl border border-amber-100">
                <span class="text-[10px] text-amber-600 font-bold uppercase block">Forma</span>
                <span class="text-xs font-black text-amber-900">{{ $tip->nombre ?? 'Tabletas' }}</span>
            </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">Fórmula y Descripción</span>
            <p class="text-sm font-medium text-slate-700 mt-1 leading-relaxed">{{ $producto->descripcion }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">Precio Unitario</span>
                <span class="text-xl font-black text-blue-900">${{ number_format($producto->precio, 2) }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">Existencia</span>
                <span class="text-xl font-black text-emerald-700">{{ $producto->existencia }} Unidades</span>
            </div>
        </div>
    </div>

    <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end gap-3">
        <a href="{{ url('/productos/editar/' . $producto->id) }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-md"><i class="bi bi-pencil-square mr-1"></i> Editar</a>
    </div>
</div>
@endsection
