@extends('plantilla/layout')

@section('contenido')
<div class="max-w-xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl p-8">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Registrar Categoría</h1>
            <p class="text-xs text-slate-500 mt-1">Consumiendo API REST vía HTTP Client</p>
        </div>
        <a href="{{ url('/categorias/listado') }}" class="text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 px-3.5 py-2 rounded-xl transition-all">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 font-bold space-y-1">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle-fill mr-1"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/categorias/guardar') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre de la Categoría</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl p-3">
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ url('/categorias/listado') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-600 text-xs font-bold">Cancelar</a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md">Guardar Categoría</button>
        </div>
    </form>
</div>
@endsection
