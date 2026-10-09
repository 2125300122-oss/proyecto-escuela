<!DOCTYPE html>
<html lang="es">

<!-- SEGMENTO 1: HEADER -->
@include('plantilla/header')

<body class="bg-gray-50 font-sans antialiased text-gray-900 flex flex-col min-h-screen">

    <!-- SEGMENTO 2: NAVBAR Y WIDGET DE APIS -->
    @include('plantilla/navbar')

    <!-- SEGMENTO 3: CONTENIDO PRINCIPAL DE CADA SUBVISTA -->
    <main class="container mx-auto px-4 mt-36 mb-12 flex-grow">
        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-10 border border-gray-100 ring-1 ring-gray-900/5">
            @yield('contenido')
        </div>
    </main>

    <!-- FOOTER -->
    @include('plantilla/footer')

</body>
</html>
