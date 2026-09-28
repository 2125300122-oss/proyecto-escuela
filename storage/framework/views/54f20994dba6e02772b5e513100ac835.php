

<?php $__env->startSection('contenido'); ?>
<div class="max-w-4xl mx-auto">
    <!-- ENCABEZADO DEL FORMULARIO -->
    <div class="mb-8 border-b border-gray-100 pb-4 flex items-center justify-between">
        <div>
            <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Productos / Medicamentos</span>
            <h1 class="text-3xl font-black text-blue-900">Formulario de Registro de Producto</h1>
            <p class="text-sm text-gray-500 mt-1">Ingrese los detalles del medicamento o producto médico para añadirlo al inventario.</p>
        </div>
        <a href="<?php echo e(url('/productos/listado')); ?>" class="text-gray-600 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-xs px-4 py-2.5 transition-all flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Volver al Catálogo
        </a>
    </div>

    <!-- FORMULARIO -->
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- NOMBRE COMERCIAL -->
            <div class="md:col-span-2">
                <label for="nombre" class="block mb-2 text-sm font-bold text-gray-700">Nombre Comercial del Producto <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-capsule-fill"></i>
                    </div>
                    <input type="text" id="nombre" name="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="Ej. Paracetamol 500mg Tab" required>
                </div>
            </div>

            <!-- DESCRIPCIÓN / COMPUESTO -->
            <div class="md:col-span-2">
                <label for="descripcion" class="block mb-2 text-sm font-bold text-gray-700">Descripción / Fórmula y Fórmulas Activas <span class="text-red-500">*</span></label>
                <textarea id="descripcion" name="descripcion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Ej. Analgésico y antipirético. Caja con 20 tabletas." required></textarea>
            </div>

            <!-- PRECIO UNITARIO -->
            <div>
                <label for="precio" class="block mb-2 text-sm font-bold text-gray-700">Precio de Venta ($ MXN) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400 font-bold">
                        $
                    </div>
                    <input type="number" step="0.01" min="0" id="precio" name="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="45.50" required>
                </div>
            </div>

            <!-- EXISTENCIA / STOCK -->
            <div>
                <label for="existencia" class="block mb-2 text-sm font-bold text-gray-700">Stock / Existencia Inicial <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-gray-400">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <input type="number" min="0" id="existencia" name="existencia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-3" placeholder="50" required>
                </div>
            </div>
        </div>

        <!-- FOTOGRAFÍAS DEL PRODUCTO -->
        <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100">
            <label class="block mb-3 text-sm font-bold text-blue-900">Imágenes del Producto / Caja (Opcional)</label>
            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Imagen Principal</label>
                    <input type="file" name="imagen1" accept="image/*" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white p-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Imagen Secundaria 1</label>
                    <input type="file" name="imagen2" accept="image/*" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white p-2">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Imagen Secundaria 2</label>
                    <input type="file" name="imagen3" accept="image/*" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white p-2">
                </div>
            </div>
        </div>

        <!-- BOTONES DE ACCIÓN -->
        <div class="pt-4 flex items-center gap-4">
            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-md flex items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i> Guardar en Inventario
            </button>
            <button type="reset" class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-bold rounded-xl text-sm px-6 py-3 transition-all">
                Limpiar
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\5aCIOA\resources\views/productos/formulario.blade.php ENDPATH**/ ?>