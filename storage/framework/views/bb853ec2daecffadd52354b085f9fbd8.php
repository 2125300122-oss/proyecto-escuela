<!DOCTYPE html>
<html lang="es">

<!-- SEGMENTO 1: HEADER -->
<?php echo $__env->make('plantilla.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="bg-gray-50 font-sans antialiased text-gray-900 flex flex-col min-h-screen">

    <!-- SEGMENTO 2: NAVBAR -->
    <?php echo $__env->make('plantilla.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- SEGMENTO 3: CONTENIDO PRINCIPAL DE CADA SUBVISTA -->
    <main class="container mx-auto px-4 mt-28 mb-12 flex-grow">
        <div class="bg-white rounded-3xl shadow-xl p-6 md:p-10 border border-gray-100 ring-1 ring-gray-900/5">
            <?php echo $__env->yieldContent('contenido'); ?>
        </div>
    </main>

    <!-- FOOTER -->
    <?php echo $__env->make('plantilla.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\5aCIOA\resources\views/plantilla/layout.blade.php ENDPATH**/ ?>