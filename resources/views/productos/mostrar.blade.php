@extends('plantilla/layout')

@section('contenido')
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Ficha Detallada (Solo Lectura)</span>
        <h1 class="text-3xl font-black text-blue-900">Producto / Medicamento #{{ $producto->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">Consulta la información del registro con nombres de llaves foráneas resueltas.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ url('/productos/editar/' . $producto->id) }}" class="text-white bg-amber-600 hover:bg-amber-700 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-pencil-square"></i> Editar Producto
        </a>
        <a href="{{ url('/productos/listado') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-5 py-3 transition-all flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-gray-50/50 p-6 md:p-8 rounded-3xl border border-gray-100">

    <!-- FOTOGRAFÍA / IMAGEN VINCULADA POR ID -->
    <div class="flex flex-col items-center justify-center bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
        <img src="{{ asset($producto->imagen1) }}" alt="Fotografía del Producto" class="w-48 h-48 object-cover rounded-2xl border border-gray-200 shadow-md mb-4" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($producto->nombre) }}&background=0D8ABC&color=fff'">
        <span class="text-xs text-gray-400 font-mono">Imagen por ID: producto_{{ $producto->id }}.png</span>
    </div>

    <!-- INFORMACIÓN Y ATRIBUTOS (SOLO LECTURA) -->
    <div class="md:col-span-2 space-y-6">

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Nombre Comercial</span>
                <div class="text-2xl font-black text-blue-900">{{ $producto->nombre }}</div>
            </div>

            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Descripción / Fórmula Terapéutica</span>
                <p class="text-gray-700 text-sm leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $producto->descripcion }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <!-- DEPENDENCIA FK 1: CATEGORÍA -->
                <div class="bg-blue-50/60 p-3.5 rounded-xl border border-blue-100">
                    <span class="text-xs font-extrabold text-blue-800 uppercase block mb-1">Categoría (FK Resuelta)</span>
                    <span class="font-black text-blue-900 text-sm">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</span>
                </div>

                <!-- DEPENDENCIA FK 2: TIPO -->
                <div class="bg-purple-50/60 p-3.5 rounded-xl border border-purple-100">
                    <span class="text-xs font-extrabold text-purple-800 uppercase block mb-1">Forma Farmacéutica (FK)</span>
                    <span class="font-black text-purple-900 text-sm">{{ $producto->tipo->nombre ?? 'Sin tipo' }}</span>
                </div>

                <!-- DEPENDENCIA FK 3: MARCA -->
                <div class="bg-amber-50/60 p-3.5 rounded-xl border border-amber-100">
                    <span class="text-xs font-extrabold text-amber-800 uppercase block mb-1">Laboratorio / Marca (FK)</span>
                    <span class="font-black text-amber-900 text-sm">{{ $producto->marca->nombre ?? 'Sin marca' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 border-t border-gray-100">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Precio Unitario</span>
                    <span class="text-xl font-black text-gray-900">${{ number_format($producto->precio, 2) }} MXN</span>
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Descuento Aplicable</span>
                    <span class="text-xl font-bold text-green-600">${{ number_format($producto->descuento, 2) }} MXN</span>
                </div>

                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase block mb-1">Existencia en Stock</span>
                    <span class="inline-block px-3 py-1 text-xs font-extrabold rounded-full bg-green-100 text-green-800">
                        {{ $producto->existencia }} Unidades
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
