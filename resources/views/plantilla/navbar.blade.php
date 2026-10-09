<!-- WIDGET API EN LA PARTE SUPERIOR -->
@include('plantilla/widget_api')

<!-- NAVBAR DE LA PLANTILLA ADMINISTRATIVA -->
<nav class="bg-white border-b border-gray-200 fixed w-full z-30 top-8 start-0 shadow-sm">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        <!-- LOGO Y TÍTULO -->
        <a href="{{ url('/productos/listado') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="bg-blue-600 p-2.5 rounded-xl shadow-md flex items-center justify-center">
                <i class="bi bi-capsule-fill text-white text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="self-center text-xl font-black whitespace-nowrap text-blue-900 tracking-tight">FARMACIA SALUD</span>
                <span class="text-xs font-semibold text-blue-600 -mt-1">Panel Administrativo</span>
            </div>
        </a>

        <!-- IDENTIFICACIÓN DEL USUARIO Y BOTÓN DE SALIR / LOGOUT -->
        <div class="flex items-center gap-3 md:order-2">
            @if (Auth::guard('admin')->check())
                <div class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-2xl border border-blue-100">
                    <img src="{{ asset(Auth::guard('admin')->user()->imagen ?? 'imagenes/administradores/administrador_1.png') }}" alt="Admin" class="w-8 h-8 rounded-full object-cover border border-blue-200" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->nombres ?? 'Admin') }}&background=0D8ABC&color=fff'">
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-black text-blue-900 leading-tight">
                            {{ Auth::guard('admin')->user()->nombres }} {{ Auth::guard('admin')->user()->apellidos }}
                        </span>
                        <span class="text-[10px] font-bold text-blue-600">
                            {{ Auth::guard('admin')->user()->rol ?? 'Administrador' }}
                        </span>
                    </div>
                </div>

                <!-- BOTÓN CERRAR SESIÓN -->
                <form action="{{ url('/logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-xl border border-red-200 transition-all flex items-center gap-1.5 shadow-sm" title="Cerrar Sesión">
                        <i class="bi bi-box-arrow-right text-sm"></i> <span class="hidden sm:inline">Salir</span>
                    </button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="text-xs font-bold text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl border border-blue-200 transition-all flex items-center gap-1.5 shadow-sm">
                    <i class="bi bi-box-arrow-in-right text-sm"></i> Iniciar Sesión
                </a>
            @endif

            <!-- BOTÓN COLLAPSE MÓVIL -->
            <button data-collapse-toggle="navbar-dropdown" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-xl md:hidden hover:bg-gray-100 focus:outline-none" aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Abrir menú</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>

        <!-- ENLACES DE NAVEGACIÓN -->
        <div class="hidden w-full md:block md:w-auto md:order-1" id="navbar-dropdown">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-2xl bg-gray-50 md:space-x-2 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white items-center">

                <!-- INICIO / LISTADO PRODUCTOS -->
                <li>
                    <a href="{{ url('/productos/listado') }}" class="block py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 transition-colors flex items-center gap-1.5 font-semibold">
                        <i class="bi bi-box-seam-fill text-blue-600"></i> Inventario
                    </a>
                </li>

                <!-- DROPDOWN ADMINISTRADORES -->
                <li>
                    <button id="dropdownAdminLink" data-dropdown-toggle="dropdownAdmin" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-shield-lock-fill text-blue-600"></i> Admins</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownAdmin" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownAdminLink">
                            <li><a href="{{ url('/administradores/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-list-ul text-blue-600"></i> Listado</a></li>
                            <li><a href="{{ url('/administradores/formulario') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-person-plus-fill text-blue-600"></i> Formulario Registro</a></li>
                        </ul>
                    </div>
                </li>

                <!-- DROPDOWN CLIENTES -->
                <li>
                    <button id="dropdownClientesLink" data-dropdown-toggle="dropdownClientes" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-people-fill text-blue-600"></i> Clientes</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownClientes" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownClientesLink">
                            <li><a href="{{ url('/clientes/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-table text-blue-600"></i> Listado Clientes</a></li>
                            <li><a href="{{ url('/clientes/formulario') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-person-add text-blue-600"></i> Formulario Cliente</a></li>
                        </ul>
                    </div>
                </li>

                <!-- DROPDOWN CATEGORÍAS -->
                <li>
                    <button id="dropdownCategoriasLink" data-dropdown-toggle="dropdownCategorias" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-folder-fill text-blue-600"></i> Categorías</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownCategorias" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownCategoriasLink">
                            <li><a href="{{ url('/categorias/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-list-stars text-blue-600"></i> Listado Categorías</a></li>
                            <li><a href="{{ url('/categorias/formulario') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-folder-plus text-blue-600"></i> Nueva Categoría</a></li>
                        </ul>
                    </div>
                </li>

                <!-- DROPDOWN MARCAS -->
                <li>
                    <button id="dropdownMarcasLink" data-dropdown-toggle="dropdownMarcas" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-tags-fill text-blue-600"></i> Marcas</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownMarcas" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownMarcasLink">
                            <li><a href="{{ url('/marcas/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-tags text-blue-600"></i> Listado Marcas</a></li>
                            <li><a href="{{ url('/marcas/formulario') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-tag-fill text-blue-600"></i> Nueva Marca</a></li>
                        </ul>
                    </div>
                </li>

                <!-- DROPDOWN TIPOS -->
                <li>
                    <button id="dropdownTiposLink" data-dropdown-toggle="dropdownTipos" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-grid-fill text-blue-600"></i> Tipos</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownTipos" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownTiposLink">
                            <li><a href="{{ url('/tipos/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-grid text-blue-600"></i> Listado Tipos</a></li>
                            <li><a href="{{ url('/tipos/formulario') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-plus-square-fill text-blue-600"></i> Nuevo Tipo</a></li>
                        </ul>
                    </div>
                </li>

                <!-- DROPDOWN EMPLEADOS -->
                <li>
                    <button id="dropdownEmpleadosLink" data-dropdown-toggle="dropdownEmpleados" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-person-badge-fill text-blue-600"></i> Empleados</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownEmpleados" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownEmpleadosLink">
                            <li><a href="{{ url('/empleados/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-person-lines-fill text-blue-600"></i> Listado Empleados</a></li>
                        </ul>
                    </div>
                </li>

                <!-- DROPDOWN PEDIDOS -->
                <li>
                    <button id="dropdownPedidosLink" data-dropdown-toggle="dropdownPedidos" class="flex items-center justify-between w-full py-2 px-3 text-gray-700 rounded-lg hover:bg-blue-50 md:hover:bg-transparent md:hover:text-blue-600 md:w-auto font-semibold transition-colors">
                        <span class="flex items-center gap-1.5"><i class="bi bi-cart-check-fill text-blue-600"></i> Pedidos</span>
                        <svg class="w-2.5 h-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>
                    </button>
                    <div id="dropdownPedidos" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-2xl shadow-xl w-52 border border-gray-100">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownPedidosLink">
                            <li><a href="{{ url('/pedidos/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-receipt text-blue-600"></i> Listado Pedidos</a></li>
                            <li><a href="{{ url('/pedidos/formulario') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-cart-plus-fill text-blue-600"></i> Formulario Pedido</a></li>
                            <li><a href="{{ url('/productos_pedidos/listado') }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2"><i class="bi bi-list-check text-blue-600"></i> Detalles / Productos en Pedido</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
