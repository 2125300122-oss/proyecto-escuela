@extends('plantilla/layout')

@section('contenido')
<div class="max-w-4xl mx-auto space-y-10">
    <div class="text-center space-y-3">
        <span class="px-3 py-1 text-xs font-bold bg-blue-100 text-blue-800 rounded-full">Atención a Clientes</span>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Contacto & Ubicación</h1>
        <p class="text-slate-500 text-sm max-w-xl mx-auto">
            ¿Tienes dudas sobre algún medicamento o pedido? Escríbenos y nuestro equipo te responderá de inmediato.
        </p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-6">
            <h3 class="text-lg font-black text-slate-900">Información Directa</h3>
            <div class="space-y-4 text-xs font-medium text-slate-600">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-lg"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <span class="font-bold text-slate-900 block">Dirección principal</span>
                        <span>Av. Vallarta #4500, Guadalajara, Jalisco.</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-lg"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <span class="font-bold text-slate-900 block">Teléfono / WhatsApp</span>
                        <span>+52 (33) 1234-5678</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-lg"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <span class="font-bold text-slate-900 block">Horario de atención</span>
                        <span>Lunes a Domingo de 8:00 AM a 10:00 PM</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="#" method="GET" onsubmit="alert('¡Gracias por tu mensaje! Te contactaremos pronto.'); return false;" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre Completo</label>
                <input type="text" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico</label>
                <input type="email" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Mensaje</label>
                <textarea required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3 h-24"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 rounded-xl shadow-md">Enviar Mensaje</button>
        </form>
    </div>
</div>
@endsection
