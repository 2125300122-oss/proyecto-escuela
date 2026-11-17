@extends('plantilla/layout')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Registrar Cliente</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/clientes/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
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

    <form action="{{ url('/clientes/guardar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombres</label>
                <input type="text" name="nombres" value="{{ old('nombres') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Apellidos</label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico</label>
            <input type="email" name="correo" value="{{ old('correo') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3" placeholder="Ej. Av. Hidalgo #123">
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ url('/clientes/listado') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold">Cancelar</a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md">Guardar Cliente</button>
        </div>
    </form>
</div>
@endsection
