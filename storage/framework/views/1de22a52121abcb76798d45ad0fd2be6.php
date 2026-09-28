

<?php $__env->startSection('contenido'); ?>
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Tipos de Presentación</span>
        <h1 class="text-3xl font-black text-blue-900">Formas Farmacéuticas Registradas</h1>
        <p class="text-sm text-gray-500 mt-1">Lista de tipos de presentación para productos y medicamentos.</p>
    </div>
    <a href="<?php echo e(url('/tipos/formulario')); ?>" class="text-white bg-green-600 hover:bg-green-700 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-capsule-fill text-lg"></i> Registrar Nuevo Tipo
    </a>
</div>

<?php if(session('exito')): ?>
    <div class="p-4 mb-6 text-sm text-green-800 rounded-2xl bg-green-50 border border-green-200 flex items-center gap-2" role="alert">
        <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
        <span><?php echo e(session('exito')); ?></span>
    </div>
<?php endif; ?>

<div class="relative overflow-x-auto shadow-md sm:rounded-2xl border border-gray-100 bg-white">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-blue-900 uppercase bg-blue-50/70 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-black">Icono</th>
                <th scope="col" class="px-6 py-4 font-black">ID</th>
                <th scope="col" class="px-6 py-4 font-black">Forma Farmacéutica / Tipo</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php $__empty_1 = true; $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <img src="<?php echo e(asset($t->imagen)); ?>" alt="Icono" class="w-10 h-10 rounded-xl object-cover border border-gray-200 shadow-sm" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($t->nombre)); ?>&background=0D8ABC&color=fff'">
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">#<?php echo e($t->id); ?></td>
                    <td class="px-6 py-4 font-bold text-gray-900"><?php echo e($t->nombre); ?></td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-bold rounded-full <?php echo e($t->estado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($t->estado ? 'Activo' : 'Inactivo'); ?>

                        </span>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="p-10 text-center text-gray-400 italic bg-white">
                        <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                        No hay tipos de presentación registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\5aCIOA\resources\views/tipos/listado.blade.php ENDPATH**/ ?>