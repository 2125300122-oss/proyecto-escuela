<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia Salud - Panel de Administración</title>
    <!-- Tailwind CSS y Flowbite CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 antialiased">

    <!-- TOP NAVBAR -->
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Abrir sidebar</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="<?php echo e(url('/')); ?>" class="flex ms-2 md:me-24 items-center space-x-3">
                        <div class="bg-[#000d5e] p-2 rounded-lg text-white">
                            <i class="bi bi-capsule-fill text-lg"></i>
                        </div>
                        <span class="self-center text-xl font-bold whitespace-nowrap text-[#000d5e] dark:text-white">FARMACIA SALUD</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="<?php echo e(url('/inicio')); ?>" class="flex items-center p-2 text-gray-700 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l1.293 1.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <!-- MÓDULO ADMINISTRADORES -->
                <li>
                    <a href="<?php echo e(url('/admin/listar')); ?>" class="flex items-center p-2 text-gray-700 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="bi bi-shield-lock text-gray-500 text-lg"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Administradores</span>
                    </a>
                </li>

                <!-- MÓDULO CLIENTES -->
                <li>
                    <a href="<?php echo e(url('/clientes')); ?>" class="flex items-center p-2 text-gray-700 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="bi bi-people text-gray-500 text-lg"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Clientes</span>
                    </a>
                </li>

                <!-- MÓDULO PRODUCTOS -->
                <li>
                    <a href="<?php echo e(url('/info-producto')); ?>" class="flex items-center p-2 text-gray-700 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="bi bi-box-seam text-gray-500 text-lg"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">Productos / Catálogo</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- CONTENIDO PRINCIPAL DE VISTAS -->
    <div class="p-4 sm:ml-64 pt-20">
        <main class="container mx-auto p-2">
            <?php echo $__env->yieldContent('contenido'); ?>
        </main>
    </div>

    <!-- FLOWBITE SCRIPT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\5aCIOA\resources\views/layouts/app.blade.php ENDPATH**/ ?>