@extends('plantilla/layout')

@section('contenido')
@php
    $producto = (object)$producto;
    $cat = is_array($producto->categoria ?? null) ? (object)$producto->categoria : ($producto->categoria ?? null);
    $mar = is_array($producto->marca ?? null) ? (object)$producto->marca : ($producto->marca ?? null);
    $tip = is_array($producto->tipo ?? null) ? (object)$producto->tipo : ($producto->tipo ?? null);
@endphp
<div class="max-w-5xl mx-auto space-y-6">
    <!-- BOTÓN VOLVER AL CATÁLOGO -->
    <div>
        <a href="{{ url('/catalogo') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 bg-slate-200/60 hover:bg-slate-200 px-4 py-2.5 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver al Catálogo de Productos
        </a>
    </div>

    <!-- TARJETA A DETALLE CON LAS 3 IMÁGENES DE LA API Y BOTÓN "AGREGAR AL CARRITO" -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-10">

        <!-- FOTOGRAFÍA PRINCIPAL Y VISOR DE LAS 3 IMÁGENES DE LA API -->
        <div class="flex flex-col items-center justify-center bg-slate-50 p-6 rounded-2xl border border-slate-100">
            <div class="w-full h-72 flex items-center justify-center overflow-hidden rounded-2xl bg-white p-3 border border-slate-200 shadow-inner">
                <img id="imagenPrincipal" src="{{ $producto->imagen1 ?? 'https://ui-avatars.com/api/?name=' . urlencode($producto->nombre ?? 'P') }}" alt="{{ $producto->nombre }}" class="max-h-full max-w-full object-contain transition-all duration-300" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($producto->nombre ?? 'P') }}&background=0D8ABC&color=fff'">
            </div>

            <!-- GALERÍA DE LAS 3 IMÁGENES ALMACENADAS EN LA API (IMAGEN1, IMAGEN2, IMAGEN3) -->
            <div class="flex gap-3 mt-4">
                @if (!empty($producto->imagen1))
                    <img src="{{ $producto->imagen1 }}" onclick="cambiarImagen(this.src)" class="w-16 h-16 rounded-xl object-cover border-2 border-blue-600 shadow-sm cursor-pointer hover:scale-105 transition-transform" title="Imagen 1 de la API">
                @endif
                @if (!empty($producto->imagen2))
                    <img src="{{ $producto->imagen2 }}" onclick="cambiarImagen(this.src)" class="w-16 h-16 rounded-xl object-cover border border-slate-300 shadow-sm cursor-pointer hover:scale-105 transition-transform opacity-80 hover:opacity-100" title="Imagen 2 de la API">
                @endif
                @if (!empty($producto->imagen3))
                    <img src="{{ $producto->imagen3 }}" onclick="cambiarImagen(this.src)" class="w-16 h-16 rounded-xl object-cover border border-slate-300 shadow-sm cursor-pointer hover:scale-105 transition-transform opacity-80 hover:opacity-100" title="Imagen 3 de la API">
                @endif
            </div>
            <span class="text-[10px] text-slate-400 font-bold mt-2">Haz clic en cualquiera de las 3 imágenes para visualizarla en grande</span>
        </div>

        <!-- ESPECIFICACIONES COMPLETAS DEL PRODUCTO Y FORMULARIO AGREGAR AL CARRITO -->
        <div class="flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1 text-xs font-black rounded-lg bg-blue-100 text-blue-800">
                        Categoría: {{ $cat->nombre ?? 'General' }}
                    </span>
                    <span class="px-3 py-1 text-xs font-black rounded-lg bg-purple-100 text-purple-800">
                        Presentación: {{ $tip->nombre ?? 'Tabletas' }}
                    </span>
                    <span class="px-3 py-1 text-xs font-black rounded-lg bg-amber-100 text-amber-800">
                        Marca: {{ $mar->nombre ?? 'Farmacia' }}
                    </span>
                </div>

                <!-- NOMBRE DEL PRODUCTO -->
                <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $producto->nombre }}
                </h1>

                <!-- PRECIO UNITARIO -->
                <div class="bg-blue-50/70 p-4 rounded-2xl border border-blue-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-blue-600 font-bold uppercase block">Precio Unitario</span>
                        <span class="text-3xl font-black text-blue-900">${{ number_format($producto->precio ?? 0, 2) }} <span class="text-xs text-slate-400 font-normal">MXN</span></span>
                    </div>
                    @if (($producto->descuento ?? 0) > 0)
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-red-100 text-red-800">
                                Descuento: -${{ number_format($producto->descuento, 2) }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- DESCRIPCIÓN DEL PRODUCTO -->
                <div>
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Descripción y Fórmula Activa</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        {{ $producto->descripcion }}
                    </p>
                </div>

                <!-- EXISTENCIA EN ALMACÉN -->
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-slate-500">Existencia en Almacén:</span>
                    <span class="px-3.5 py-1.5 text-xs font-black rounded-full {{ ($producto->existencia ?? 0) > 10 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                        <i class="bi bi-box-seam mr-1"></i> {{ $producto->existencia ?? 0 }} Unidades Disponibles
                    </span>
                </div>
            </div>

            <!-- FORMULARIO OBLIGATORIO "AGREGAR AL CARRITO DE COMPRAS" -->
            <form action="{{ url('/carrito/agregar/' . $producto->id) }}" method="POST" class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                @csrf
                <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-xl border border-slate-200">
                    <span class="text-xs font-bold text-slate-600 px-2">Cantidad:</span>
                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->existencia ?? 99 }}" class="w-16 bg-white text-slate-900 font-bold text-sm text-center border border-slate-300 rounded-lg py-2 focus:ring-2 focus:ring-amber-500 outline-none">
                </div>
                <button type="submit" class="flex-grow text-white bg-amber-600 hover:bg-amber-700 font-bold rounded-xl text-sm px-6 py-3.5 transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="bi bi-cart-plus-fill text-lg"></i> Agregar al Carrito
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function cambiarImagen(src) {
    document.getElementById('imagenPrincipal').src = src;
}
</script>
@endsection
