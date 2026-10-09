@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Edición de Registro</span>
        <h1 class="text-3xl font-black text-blue-900">Editar Producto / Medicamento #{{ $producto->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Modifica los datos del producto e invoca la actualización validada en el controlador.</p>
    </div>
    <a href="{{ url('/productos/listado') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center justify-center gap-2">
        <i class="bi bi-arrow-left"></i> Volver al Listado
    </a>
</div>

@if ($errors->any())
    <div class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-200" role="alert">
        <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill mr-1"></i> Por favor corrige los siguientes errores:</div>
        <ul class="list-disc list-inside text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('/productos/actualizar/' . $producto->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">

        <!-- NOMBRE COMERCIAL -->
        <div class="md:col-span-2">
            <label for="nombre" class="block mb-2 text-sm font-bold text-gray-900">Nombre Comercial del Medicamento *</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- DESCRIPCIÓN -->
        <div class="md:col-span-2">
            <label for="descripcion" class="block mb-2 text-sm font-bold text-gray-900">Descripción o Fórmula Terapéutica *</label>
            <textarea id="descripcion" name="descripcion" rows="3" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <!-- SELECT DEPENDIENTE: CATEGORÍA -->
        <div>
            <label for="categoria_id" class="block mb-2 text-sm font-bold text-gray-900">Categoría Terapéutica (Opción Guardada) *</label>
            <select id="categoria_id" name="categoria_id" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
                <option value="">-- Seleccione Categoría --</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id', $producto->categoria_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- SELECT DEPENDIENTE: TIPO -->
        <div>
            <label for="tipo_id" class="block mb-2 text-sm font-bold text-gray-900">Forma Farmacéutica / Tipo (Opción Guardada) *</label>
            <select id="tipo_id" name="tipo_id" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
                <option value="">-- Seleccione Tipo --</option>
                @foreach ($tipos as $tip)
                    <option value="{{ $tip->id }}" {{ old('tipo_id', $producto->tipo_id) == $tip->id ? 'selected' : '' }}>
                        {{ $tip->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- SELECT DEPENDIENTE: MARCA -->
        <div>
            <label for="marca_id" class="block mb-2 text-sm font-bold text-gray-900">Marca / Laboratorio (Opción Guardada) *</label>
            <select id="marca_id" name="marca_id" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
                <option value="">-- Seleccione Marca --</option>
                @foreach ($marcas as $mar)
                    <option value="{{ $mar->id }}" {{ old('marca_id', $producto->marca_id) == $mar->id ? 'selected' : '' }}>
                        {{ $mar->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- PRECIO -->
        <div>
            <label for="precio" class="block mb-2 text-sm font-bold text-gray-900">Precio de Venta ($ MXN) *</label>
            <input type="number" step="0.01" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- EXISTENCIA -->
        <div>
            <label for="existencia" class="block mb-2 text-sm font-bold text-gray-900">Stock / Existencias *</label>
            <input type="number" id="existencia" name="existencia" value="{{ old('existencia', $producto->existencia) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm" required>
        </div>

        <!-- DESCUENTO -->
        <div>
            <label for="descuento" class="block mb-2 text-sm font-bold text-gray-900">Descuento ($ MXN)</label>
            <input type="number" step="0.01" id="descuento" name="descuento" value="{{ old('descuento', $producto->descuento) }}" class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 shadow-sm">
        </div>

        <!-- IMAGEN -->
        <div class="md:col-span-2">
            <label for="imagen1" class="block mb-2 text-sm font-bold text-gray-900">Actualizar Imagen (Opcional)</label>
            <div class="flex items-center gap-4">
                <img src="{{ asset($producto->imagen1) }}" alt="Foto Actual" class="w-14 h-14 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($producto->nombre) }}&background=0D8ABC&color=fff'">
                <input type="file" id="imagen1" name="imagen1" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-200 rounded-xl bg-white p-2 shadow-sm">
            </div>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-4">
        <a href="{{ url('/productos/listado') }}" class="px-6 py-3 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Cancelar</a>
        <button type="submit" class="px-6 py-3 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md transition-all flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i> Guardar Cambios
        </button>
    </div>
</form>
@endsection
