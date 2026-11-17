@extends('plantilla/layout')

@section('contenido')
@php $admin = (object)$admin; @endphp
<div class="max-w-xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Detalles de Administrador</h1>
            <p class="text-xs text-slate-500 mt-1">Información leída desde la API REST</p>
        </div>
        <a href="{{ url('/administradores/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>

    <div class="space-y-4">
        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <img src="{{ str_starts_with($admin->imagen ?? '', 'http') ? $admin->imagen : asset($admin->imagen ?? 'imagenes/administradores/admin_default.jpg') }}" class="w-16 h-16 rounded-2xl object-cover border border-slate-200" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($admin->nombres) }}&background=0D8ABC&color=fff'">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase block">Usuario</span>
                <span class="text-lg font-black text-slate-900">{{ $admin->usuario }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">ID</span>
                <span class="text-base font-black text-slate-900">#{{ $admin->id }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">Rol</span>
                <span class="text-base font-black text-purple-700">{{ $admin->rol ?? 'Administrador' }}</span>
            </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">Nombre Completo</span>
            <span class="text-base font-black text-slate-900">{{ $admin->nombres }} {{ $admin->apellidos }}</span>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">Correo Electrónico</span>
            <span class="text-base font-black text-slate-900">{{ $admin->correo }}</span>
        </div>
    </div>

    <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end gap-3">
        <a href="{{ url('/administradores/editar/' . $admin->id) }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-md"><i class="bi bi-pencil-square mr-1"></i> Editar</a>
    </div>
</div>
@endsection
