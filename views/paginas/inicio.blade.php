@extends('plantilla/layout')

@section('contenido')
<div class="max-w-7xl mx-auto space-y-12">
    <!-- HERO BANNER INICIO -->
    <div class="relative bg-gradient-to-r from-blue-900 to-indigo-900 rounded-3xl p-8 md:p-14 text-white overflow-hidden shadow-2xl">
        <div class="relative z-10 max-w-2xl space-y-4">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-blue-500/30 border border-blue-400/30 text-blue-200">
                <i class="bi bi-cloud-arrow-down-fill"></i> Consumo de Datos vía HttpClient
            </span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Tu Salud y Medicamentos a un Solo Clic
            </h1>
            <p class="text-blue-100 text-sm md:text-base leading-relaxed">
                Explora nuestro catálogo interactivo de medicamentos y productos farmacéuticos alimentado dinámicamente desde nuestra API REST sin base de datos local.
            </p>
            <div class="pt-4 flex flex-wrap gap-4">
                <a href="{{ url('/catalogo') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-lg transition-all inline-flex items-center gap-2">
                    <i class="bi bi-bag-fill"></i> Ver Catálogo Completo
                </a>
                <a href="{{ url('/nosotros') }}" class="bg-white/10 hover:bg-white/20 text-white font-bold text-sm px-6 py-3.5 rounded-xl transition-all inline-flex items-center gap-2">
                    <i class="bi bi-info-circle-fill"></i> Conocer Más
                </a>
            </div>
        </div>
    </div>

    <!-- PRODUCTOS DESTACADOS DESDE LA API -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900">Productos Destacados</h2>
                <p class="text-xs text-slate-500 mt-1">Obtenidos en tiempo real desde la API REST (`GET /api/productos`)</p>
            </div>
            <a href="{{ url('/catalogo') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                Ver todos <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse ($productosDestacados as $p)
                @php $p = (object)$p; @endphp
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col justify-between p-4">
                    <div class="space-y-3">
                        <div class="w-full h-40 bg-slate-50 rounded-xl overflow-hidden">
                            <img src="{{ $p->imagen1 }}" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($p->nombre) }}&background=0D8ABC&color=fff'">
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $p->nombre }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $p->descripcion }}</p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-base font-black text-blue-900">${{ number_format($p->precio, 2) }}</span>
                        <a href="{{ url('/catalogo/detalle/' . $p->id) }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100">Ver</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 font-bold">Sin productos en la API.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
