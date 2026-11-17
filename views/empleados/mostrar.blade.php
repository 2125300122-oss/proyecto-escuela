@extends('plantilla/layout')

@section('contenido')
@php $empleado = (object)$empleado; @endphp
<div class="max-w-xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Detalle de Empleado</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/empleados/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver al Listado
        </a>
    </div>

    <div class="space-y-4">
        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <div class="w-14 h-14 bg-blue-100 text-blue-700 rounded-2xl flex items-center justify-center font-black text-2xl">
                <i class="bi bi-person-badge-fill"></i>
            </div>
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase block">Usuario: {{ $empleado->usuario }}</span>
                <span class="text-xl font-black text-slate-900">{{ $empleado->nombres }} {{ $empleado->apellidos }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">ID Empleado</span>
                <span class="text-base font-black text-slate-900">#{{ $empleado->id }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                <span class="text-xs text-slate-400 font-bold uppercase block">Puesto</span>
                <span class="text-base font-black text-purple-700">{{ $empleado->puesto ?? 'Empleado' }}</span>
            </div>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
            <span class="text-xs text-slate-400 font-bold uppercase block">Correo Electrónico</span>
            <span class="text-base font-black text-slate-900">{{ $empleado->correo }}</span>
        </div>
    </div>

    <div class="pt-6 mt-6 border-t border-slate-100 flex justify-end gap-3">
        <a href="{{ url('/empleados/editar/' . $empleado->id) }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-md"><i class="bi bi-pencil-square mr-1"></i> Editar</a>
    </div>
</div>
@endsection
