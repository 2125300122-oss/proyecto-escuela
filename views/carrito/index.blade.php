@extends('plantilla/layout')

@section('contenido')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- ENCABEZADO Y ACCIONES -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 flex items-center gap-2">
                <i class="bi bi-cart3 text-amber-600"></i> Carrito de Compras
            </h1>
            <p class="text-xs text-slate-500 mt-1">Gestionado mediante sesiones del cliente sin base de datos local</p>
        </div>

        @if (count($carrito) > 0)
            <a href="{{ url('/carrito/vaciar') }}" onclick="return confirm('¿Está seguro de vaciar el carrito completamente?')" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-4 py-2.5 rounded-xl transition-all flex items-center gap-1.5">
                <i class="bi bi-trash-fill"></i> Vaciar Carrito
            </a>
        @endif
    </div>

    <!-- MENSAJES DE ÉXITO O ERROR -->
    @if (session('exito'))
        <div class="p-4 bg-green-100 border border-green-200 text-green-800 text-xs font-bold rounded-xl flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-base"></i> {{ session('exito') }}
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 bg-red-100 border border-red-200 text-red-800 text-xs font-bold rounded-xl flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-base"></i> {{ session('error') }}
        </div>
    @endif

    <!-- CONTENIDO DEL CARRITO -->
    @if (count($carrito) > 0)
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-100 text-xs uppercase font-bold text-slate-700 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4">Producto</th>
                            <th class="px-6 py-4">Precio</th>
                            <th class="px-6 py-4 text-center">Cantidad</th>
                            <th class="px-6 py-4">Subtotal</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($carrito as $id => $item)
                            @php $item = (object)$item; @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <!-- IMAGEN Y NOMBRE -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item->imagen }}" class="w-14 h-14 object-contain rounded-xl border border-slate-200 bg-slate-50 p-1" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($item->nombre) }}&background=0D8ABC&color=fff'">
                                        <div>
                                            <a href="{{ url('/catalogo/detalle/' . $item->id) }}" class="font-bold text-slate-900 hover:text-blue-600 text-sm block line-clamp-1">
                                                {{ $item->nombre }}
                                            </a>
                                            <span class="text-[10px] text-slate-400 font-bold uppercase">ID: #{{ $item->id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- PRECIO -->
                                <td class="px-6 py-4 font-bold text-slate-800">
                                    ${{ number_format($item->precio, 2) }}
                                </td>

                                <!-- CANTIDAD (ACTUALIZAR) -->
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ url('/carrito/actualizar/' . $item->id) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="1" max="99" class="w-16 bg-slate-50 border border-slate-300 text-slate-900 font-bold text-xs text-center rounded-lg py-1.5 focus:ring-2 focus:ring-blue-500 outline-none">
                                        <button type="submit" class="bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold p-1.5 rounded-lg border border-blue-200" title="Actualizar cantidad">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                </td>

                                <!-- SUBTOTAL -->
                                <td class="px-6 py-4 font-black text-blue-900 text-base">
                                    ${{ number_format($item->subtotal ?? ($item->precio * $item->cantidad), 2) }}
                                </td>

                                <!-- ACCIONES (ELIMINAR) -->
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ url('/carrito/eliminar/' . $item->id) }}" onclick="return confirm('¿Eliminar este producto del carrito?')" class="text-slate-400 hover:text-red-600 text-base transition-colors" title="Eliminar producto">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RESUMEN Y BOTÓN PARA CREAR PEDIDO MEDIANTE LA API CON TOKEN -->
            <div class="bg-slate-50 p-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ url('/catalogo') }}" class="text-xs font-bold text-slate-700 hover:text-blue-600 inline-flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Seguir Comprando
                </a>

                <div class="flex items-center gap-6 w-full sm:w-auto justify-between sm:justify-end">
                    <div class="text-right">
                        <span class="text-xs text-slate-500 font-bold uppercase block">Total Acumulado</span>
                        <span class="text-3xl font-black text-blue-900">${{ number_format($total, 2) }} <span class="text-xs font-normal text-slate-400">MXN</span></span>
                    </div>

                    <form action="{{ url('/pedidos/crear') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-6 py-3.5 rounded-xl shadow-md transition-all flex items-center gap-2">
                            <i class="bi bi-bag-check-fill text-lg"></i> Generar Pedido & Descontar Stock
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- VISTA CARRITO VACÍO -->
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center space-y-4 shadow-sm">
            <div class="w-20 h-20 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center text-4xl mx-auto border border-amber-100">
                <i class="bi bi-cart-x-fill"></i>
            </div>
            <h2 class="text-2xl font-black text-slate-900">Tu carrito está vacío</h2>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                No has agregado productos al carrito aún. Explora nuestro catálogo de medicamentos y selecciona tus productos.
            </p>
            <div class="pt-2">
                <a href="{{ url('/catalogo') }}" class="inline-flex items-center gap-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-6 py-3.5 rounded-xl shadow-md transition-all">
                    <i class="bi bi-bag-fill"></i> Ir al Catálogo de Productos
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
