@extends('plantilla/layout')

@section('contenido')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- ENCABEZADO DEL CATÁLOGO -->
    <div class="text-center border-b border-slate-200 pb-8">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 mb-3">
            <i class="bi bi-cloud-arrow-down-fill"></i> Consumo de datos desde API REST vía HttpClient
        </span>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Catálogo de Productos y Medicamentos</h1>
        <p class="text-slate-500 text-sm max-w-2xl mx-auto mt-2">
            Consultando productos en tiempo real desde la API (`http://127.0.0.1:8000/api/productos`) sin conexión a base de datos local.
        </p>
    </div>

    <!-- BUSCADOR INTERACTIVO EN TIEMPO REAL -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-blue-50/60 p-4 rounded-2xl border border-blue-100">
        <div class="relative w-full sm:w-96">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                <i class="bi bi-search"></i>
            </div>
            <input type="text" id="inputBuscador" onkeyup="filtrarCatalogo()" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3 shadow-sm" placeholder="Buscar medicamento por nombre...">
        </div>
        <div class="text-xs font-bold text-slate-600">
            <i class="bi bi-box-seam-fill text-blue-600 mr-1"></i> {{ count($productos) }} Productos devueltos por la API
        </div>
    </div>

    <!-- REJILLA / GALERÍA DE PRODUCTOS (MUESTRA: NOMBRE, DESCRIPCIÓN, PRECIO, IMAGEN1 Y ENLACE A DETALLE) -->
    <div id="gridProductos" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($productos as $p)
            @php
                $p = (object)$p;
                $cat = is_array($p->categoria ?? null) ? (object)$p->categoria : ($p->categoria ?? null);
            @endphp
            <div class="tarjeta-producto bg-white rounded-2xl border border-slate-200 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group" data-nombre="{{ strtolower($p->nombre ?? '') }}">

                <!-- FOTOGRAFÍA PRINCIPAL (IMAGEN1 ALMACENADA EN LA API) -->
                <div>
                    <a href="{{ url('/catalogo/detalle/' . $p->id) }}" class="relative block overflow-hidden bg-slate-50 aspect-square">
                        <img src="{{ $p->imagen1 ?? 'https://ui-avatars.com/api/?name=' . urlencode($p->nombre ?? 'Producto') }}" alt="{{ $p->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nombre ?? 'P') }}&background=0D8ABC&color=fff'">
                    </a>

                    <div class="p-5 space-y-2">
                        <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-md bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $cat->nombre ?? 'General' }}
                        </span>

                        <a href="{{ url('/catalogo/detalle/' . $p->id) }}" class="block font-black text-slate-900 text-base hover:text-blue-600 transition-colors line-clamp-1">
                            {{ $p->nombre }}
                        </a>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $p->descripcion }}
                        </p>
                    </div>
                </div>

                <!-- PRECIO Y ENLACE A DETALLE -->
                <div class="p-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">Precio</span>
                        <span class="text-lg font-black text-blue-900">${{ number_format($p->precio ?? 0, 2) }}</span>
                    </div>
                    <a href="{{ url('/catalogo/detalle/' . $p->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2.5 rounded-xl shadow-md transition-all">
                        <span>Ver Detalle</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-slate-50 rounded-3xl border border-slate-200">
                <i class="bi bi-inbox text-5xl text-slate-300 block mb-3"></i>
                <p class="text-slate-500 font-bold">No hay productos disponibles desde la API en este momento.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
function filtrarCatalogo() {
    let input = document.getElementById('inputBuscador').value.toLowerCase();
    let tarjetas = document.getElementsByClassName('tarjeta-producto');

    for (let i = 0; i < tarjetas.length; i++) {
        let nombre = tarjetas[i].getAttribute('data-nombre');
        if (nombre.includes(input)) {
            tarjetas[i].style.display = "flex";
        } else {
            tarjetas[i].style.display = "none";
        }
    }
}
</script>
@endsection
