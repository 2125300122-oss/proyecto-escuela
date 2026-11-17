@extends('plantilla/layout')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-10">
    <div class="text-center space-y-3">
        <span class="px-3 py-1 text-xs font-bold bg-blue-100 text-blue-800 rounded-full">Acerca de Nuestra Farmacia</span>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Sobre Nosotros</h1>
        <p class="text-slate-500 text-sm max-w-2xl mx-auto">
            Somos una farmacia digital comprometida con acercar productos de salud y bienestar mediante tecnologías modernas y arquitectura cliente-servidor orientada a servicios API.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl font-black">
                <i class="bi bi-eye-fill"></i>
            </div>
            <h3 class="font-black text-slate-900 text-lg">Nuestra Misión</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Brindar acceso rápido, seguro y confiable a medicamentos garantizando altos estándares de calidad e innovación tecnológica.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-2xl font-black">
                <i class="bi bi-rocket-takeoff-fill"></i>
            </div>
            <h3 class="font-black text-slate-900 text-lg">Nuestra Visión</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Ser la plataforma farmacéutica digital líder en la región integrada totalmente a servicios REST informativos y seguros.
            </p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl font-black">
                <i class="bi bi-award-fill"></i>
            </div>
            <h3 class="font-black text-slate-900 text-lg">Valores</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Compromiso con la salud, ética profesional, transparencia, rapidez y eficiencia tecnológica en cada consulta de API.
            </p>
        </div>
    </div>
</div>
@endsection
