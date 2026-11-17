@extends('plantilla/layout')

@section('contenido')
@php $producto = (object)$producto; @endphp
<div class="max-w-2xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Editar Producto #{{ $producto->id }}</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/productos/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 font-bold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle-fill mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/productos/actualizar/' . $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre Comercial del Producto</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Fórmula / Descripción</label>
            <textarea name="descripcion" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3 h-24">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Categoría</label>
                <select name="categoria_id" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
                    @foreach ($categorias as $cat)
                        @php $cat = (object)$cat; @endphp
                        <option value="{{ $cat->id }}" {{ ($producto->categoria_id ?? null) == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Marca / Laboratorio</label>
                <select name="marca_id" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
                    @foreach ($marcas as $mar)
                        @php $mar = (object)$mar; @endphp
                        <option value="{{ $mar->id }}" {{ ($producto->marca_id ?? null) == $mar->id ? 'selected' : '' }}>{{ $mar->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Forma Farmacéutica</label>
                <select name="tipo_id" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
                    @foreach ($tipos as $tip)
                        @php $tip = (object)$tip; @endphp
                        <option value="{{ $tip->id }}" {{ ($producto->tipo_id ?? null) == $tip->id ? 'selected' : '' }}>{{ $tip->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Precio Unitario ($)</label>
                <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Existencias en Almacén</label>
                <input type="number" name="existencia" value="{{ old('existencia', $producto->existencia) }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Descuento ($)</label>
                <input type="number" step="0.01" name="descuento" value="{{ old('descuento', $producto->descuento) }}" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ url('/productos/listado') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold">Cancelar</a>
            <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-md">Actualizar Producto</button>
        </div>
    </form>
</div>
@endsection
