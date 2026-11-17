<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente Final - Catálogo, Carrito, Pedidos & Autenticación de Usuario</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">

    @php
        $carritoSesion = session('carrito', []);
        $itemsEnCarrito = count($carritoSesion);
        $clienteSesion = session('cliente');
        $userToken = session('userToken');
    @endphp

    <!-- ENCABEZADO Y MENÚ DE NAVEGACIÓN (HEADER) -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- LOGO DE LA FARMACIA -->
                <a href="{{ url('/inicio') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-xl shadow-md group-hover:scale-105 transition-transform">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 tracking-tight block leading-tight">FarmaCliente</span>
                        <span class="text-[10px] font-bold text-blue-600 tracking-widest uppercase block">Pedidos & Carrito</span>
                    </div>
                </a>

                <!-- MENÚ DE NAVEGACIÓN Y OPCIONES DE USUARIO -->
                <nav class="flex items-center gap-2">
                    <a href="{{ url('/inicio') }}" class="px-3 py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition-all inline-flex items-center gap-1.5">
                        <i class="bi bi-house-door-fill text-blue-600"></i>
                        <span>Inicio</span>
                    </a>
                    <a href="{{ url('/nosotros') }}" class="px-3 py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition-all inline-flex items-center gap-1.5">
                        <i class="bi bi-people-fill text-blue-600"></i>
                        <span>Nosotros</span>
                    </a>
                    <a href="{{ url('/catalogo') }}" class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all inline-flex items-center gap-1.5">
                        <i class="bi bi-grid-3x3-gap-fill"></i>
                        <span>Catálogo</span>
                    </a>
                    <a href="{{ url('/contacto') }}" class="px-3 py-2 rounded-xl text-xs sm:text-sm font-bold text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition-all inline-flex items-center gap-1.5">
                        <i class="bi bi-envelope-fill text-blue-600"></i>
                        <span>Contacto</span>
                    </a>

                    <!-- ICONO Y CONTADOR DEL CARRITO DE COMPRAS -->
                    <a href="{{ url('/carrito') }}" class="relative px-3 py-2 rounded-xl text-xs sm:text-sm font-bold text-amber-900 bg-amber-100/80 hover:bg-amber-200 border border-amber-300 shadow-sm transition-all inline-flex items-center gap-2">
                        <i class="bi bi-cart3 text-amber-700 text-base"></i>
                        <span>Carrito</span>
                        <span class="bg-amber-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow-sm">
                            {{ $itemsEnCarrito }}
                        </span>
                    </a>

                    <!-- OPCIONES DINÁMICAS SEGÚN ESTADO DE AUTENTICACIÓN DEL USUARIO -->
                    @if ($userToken)
                        <div class="flex items-center gap-2 ml-2 pl-2 border-l border-slate-200">
                            <a href="{{ url('/usuario/pedidos') }}" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-blue-600 hover:bg-slate-50 transition-all inline-flex items-center gap-1.5">
                                <i class="bi bi-bag-check-fill text-blue-600"></i>
                                <span>Mis Pedidos</span>
                            </a>
                            <a href="{{ url('/usuario/perfil') }}" class="px-3 py-2 rounded-xl text-xs font-black text-blue-900 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition-all inline-flex items-center gap-1.5">
                                <i class="bi bi-person-circle text-blue-600 text-base"></i>
                                <span>{{ $clienteSesion['nombres'] ?? 'Mi Perfil' }}</span>
                            </a>
                            <a href="{{ url('/usuario/logout') }}" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all" title="Cerrar Sesión">
                                <i class="bi bi-box-arrow-right text-base"></i>
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 ml-2 pl-2 border-l border-slate-200">
                            <a href="{{ url('/usuario/login') }}" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:text-blue-600 transition-all">
                                Iniciar Sesión
                            </a>
                            <a href="{{ url('/usuario/registro') }}" class="px-3 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                                Registrarse
                            </a>
                        </div>
                    @endif
                </nav>

            </div>
        </div>
    </header>

    <!-- CONTENIDO DE LA PÁGINA (YIELD CONTENIDO) -->
    <main class="flex-grow py-8 px-4 sm:px-6 lg:px-8">
        @yield('contenido')
    </main>

    <!-- PIE DE PÁGINA (FOOTER) -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center space-y-4">
            <div class="flex justify-center items-center gap-6 text-xs font-bold text-slate-600">
                <a href="{{ url('/inicio') }}" class="hover:text-blue-600">🏠 Inicio</a>
                <a href="{{ url('/nosotros') }}" class="hover:text-blue-600">👥 Nosotros</a>
                <a href="{{ url('/catalogo') }}" class="hover:text-blue-600">🛍️ Catálogo</a>
                <a href="{{ url('/carrito') }}" class="hover:text-blue-600">🛒 Carrito ({{ $itemsEnCarrito }})</a>
                @if ($userToken)
                    <a href="{{ url('/usuario/pedidos') }}" class="hover:text-blue-600">📋 Mis Pedidos</a>
                @endif
                <a href="{{ url('/contacto') }}" class="hover:text-blue-600">📩 Contacto</a>
            </div>
            <p class="text-xs text-slate-400 font-medium">
                © {{ date('Y') }} Sitio Web Cliente Final - Gestión de Pedidos con Token Sanctum & Descuento de Stock en API.
            </p>
        </div>
    </footer>

</body>
</html>
