@extends('plantilla/layout')

@section('contenido')
<div class="max-w-4xl mx-auto">
    <div class="mb-8 border-b border-gray-100 pb-4 flex items-center justify-between">
        <div>
            <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Pedidos / Ventas</span>
            <h1 class="text-3xl font-black text-blue-900">Formulario de Registro de Pedido</h1>
            <p class="text-sm text-gray-500 mt-1">Ingrese los datos de la nueva venta o pedido realizado por un cliente.</p>
        </div>
        <a href="{{ url('/pedidos/listado') }}" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-xs px-4 py-2.5 transition-all flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Volver al Listado
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

    <form action="{{ url('/pedidos/guardar') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid gap-6 md:grid-cols-2">
            <!-- CLIENTE (LLAVE FORÁNEA) -->
            <div class="md:col-span-2">
                <label for="cliente_id" class="block mb-2 text-sm font-bold text-gray-700">Cliente Requerido <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <select id="cliente_id" name="cliente_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" required>
                        <option value="">-- Seleccione el cliente --</option>
                        @foreach ($clientes as $cli)
                            <option value="{{ $cli->id }}" {{ old('cliente_id') == $cli->id ? 'selected' : '' }}>
                                {{ $cli->nombres }} {{ $cli->apellidos }} ({{ $cli->correo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('cliente_id')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- FECHA Y HORA DEL PEDIDO -->
            <div>
                <label for="fecha" class="block mb-2 text-sm font-bold text-gray-700">Fecha y Hora <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <input type="datetime-local" id="fecha" name="fecha" value="{{ old('fecha', date('Y-m-d\TH:i')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" required>
                </div>
                @error('fecha')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- ESTADO DEL PEDIDO -->
            <div>
                <label for="estado" class="block mb-2 text-sm font-bold text-gray-700">Estado del Pedido <span class="text-red-500">*</span></label>
                <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" required>
                    <option value="Pagado" {{ old('estado') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Entregado" {{ old('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="En Camino" {{ old('estado') == 'En Camino' ? 'selected' : '' }}>En Camino</option>
                </select>
                @error('estado')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- TOTAL VENTA -->
            <div>
                <label for="total" class="block mb-2 text-sm font-bold text-gray-700">Monto Total ($ MXN) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400 font-bold">$</div>
                    <input type="number" step="0.01" min="0" id="total" name="total" value="{{ old('total') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="150.00" required>
                </div>
                @error('total')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- DESCUENTO GLOBAL -->
            <div>
                <label for="descuento" class="block mb-2 text-sm font-bold text-gray-700">Descuento ($ MXN)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-tag-fill"></i>
                    </div>
                    <input type="number" step="0.01" min="0" id="descuento" name="descuento" value="{{ old('descuento', 0) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="0.00">
                </div>
                @error('descuento')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- IVA (OPCIONAL, SE CALCULA SI SE DEJA EN BLANCO) -->
            <div class="md:col-span-2">
                <label for="iva" class="block mb-2 text-sm font-bold text-gray-700">IVA Aplicado ($ MXN - Opcional, auto-calculado al 16%)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-percent"></i>
                    </div>
                    <input type="number" step="0.01" min="0" id="iva" name="iva" value="{{ old('iva') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="Dejar vacío para calcular 16%">
                </div>
                @error('iva')
                    <p class="mt-1 text-xs text-red-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="pt-4 flex items-center gap-4">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-md flex items-center gap-2">
                <i class="bi bi-cart-check-fill"></i> Guardar Pedido
            </button>
            <button type="reset" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-6 py-3 transition-all">
                Limpiar Formulario
            </button>
        </div>
    </form>
</div>
@endsection
