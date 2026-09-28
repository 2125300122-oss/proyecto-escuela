@extends('plantilla/layout')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 border-b border-gray-100 pb-4 flex items-center justify-between">
        <div>
            <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Productos / Medicamentos</span>
            <h1 class="text-3xl font-black text-blue-900">Formulario de Registro de Producto</h1>
            <p class="text-sm text-gray-500 mt-1">Ingrese los detalles del medicamento o producto médico para añadirlo al inventario.</p>
        </div>
        <a href="{{ url('/productos/listado') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-xs px-4 py-2.5 transition-all flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Volver al Catálogo
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 mb-6 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-200">
            <div class="font-bold mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Por favor corrija los siguientes errores:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/productos/guardar') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid gap-6 md:grid-cols-2">
            <!-- NOMBRE COMERCIAL -->
            <div class="md:col-span-2">
                <label for="nombre" class="block mb-2 text-sm font-bold text-gray-700">Nombre Comercial del Producto <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-capsule-fill"></i>
                    </div>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="Ej. Paracetamol 500mg Tab" required>
                </div>
                @error('nombre')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- DESCRIPCIÓN -->
            <div class="md:col-span-2">
                <label for="descripcion" class="block mb-2 text-sm font-bold text-gray-700">Descripción / Fórmula Activa <span class="text-red-500">*</span></label>
                <textarea id="descripcion" name="descripcion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Ej. Analgésico y antipirético. Caja con 20 tabletas." required>{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- SELECT CATEGORÍA (DEPENDENCIA) -->
            <div>
                <label for="categoria_id" class="block mb-2 text-sm font-bold text-gray-700">Categoría <span class="text-red-500">*</span></label>
                <select id="categoria_id" name="categoria_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                    <option value="">-- Seleccionar Categoría --</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- SELECT TIPO DE PRESENTACIÓN (DEPENDENCIA) -->
            <div>
                <label for="tipo_id" class="block mb-2 text-sm font-bold text-gray-700">Tipo / Forma Farmacéutica <span class="text-red-500">*</span></label>
                <select id="tipo_id" name="tipo_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                    <option value="">-- Seleccionar Tipo --</option>
                    @foreach ($tipos as $tp)
                        <option value="{{ $tp->id }}" {{ old('tipo_id') == $tp->id ? 'selected' : '' }}>{{ $tp->nombre }}</option>
                    @endforeach
                </select>
                @error('tipo_id')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- SELECT MARCA / LABORATORIO (DEPENDENCIA) -->
            <div class="md:col-span-2">
                <label for="marca_id" class="block mb-2 text-sm font-bold text-gray-700">Marca / Laboratorio <span class="text-red-500">*</span></label>
                <select id="marca_id" name="marca_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                    <option value="">-- Seleccionar Marca o Laboratorio --</option>
                    @foreach ($marcas as $mc)
                        <option value="{{ $mc->id }}" {{ old('marca_id') == $mc->id ? 'selected' : '' }}>{{ $mc->nombre }}</option>
                    @endforeach
                </select>
                @error('marca_id')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- PRECIO UNITARIO -->
            <div>
                <label for="precio" class="block mb-2 text-sm font-bold text-gray-700">Precio de Venta ($ MXN) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400 font-bold">$</div>
                    <input type="number" step="0.01" min="0" id="precio" name="precio" value="{{ old('precio') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="45.50" required>
                </div>
                @error('precio')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- EXISTENCIA / STOCK -->
            <div>
                <label for="existencia" class="block mb-2 text-sm font-bold text-gray-700">Stock / Existencia Inicial <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <input type="number" min="0" id="existencia" name="existencia" value="{{ old('existencia') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="50" required>
                </div>
                @error('existencia')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- DESCUENTO (OPCIONAL) -->
            <div class="md:col-span-2">
                <label for="descuento" class="block mb-2 text-sm font-bold text-gray-700">Descuento ($ MXN o % - Opcional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-percent"></i>
                    </div>
                    <input type="number" step="0.01" min="0" id="descuento" name="descuento" value="{{ old('descuento', 0) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="0.00">
                </div>
                @error('descuento')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- FOTOGRAFÍAS DEL PRODUCTO -->
        <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100">
            <label class="block mb-3 text-sm font-bold text-blue-900">Imágenes del Producto / Caja (Opcional)</label>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Imagen Principal</label>
                    <input type="file" name="imagen1" accept="image/*" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white p-2">
                    @error('imagen1')
                        <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Imagen Secundaria 1</label>
                    <input type="file" name="imagen2" accept="image/*" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white p-2">
                    @error('imagen2')
                        <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Imagen Secundaria 2</label>
                    <input type="file" name="imagen3" accept="image/*" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white p-2">
                    @error('imagen3')
                        <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="pt-4 flex items-center gap-4">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-md flex items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i> Guardar en Inventario
            </button>
            <button type="reset" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-6 py-3 transition-all">
                Limpiar
            </button>
        </div>
    </form>
</div>
@endsection
