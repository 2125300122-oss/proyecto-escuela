

<?php $__env->startSection('contenido'); ?>
<div class="mb-8 border-b border-gray-100 pb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <span class="text-blue-600 font-extrabold text-xs uppercase tracking-widest block mb-1">Módulo Administradores</span>
        <h1 class="text-3xl font-black text-blue-900">Listado de Administradores</h1>
        <p class="text-sm text-gray-500 mt-1">Gestión del personal autorizado en el sistema de la farmacia.</p>
    </div>
    <!-- BOTÓN AGREGAR NUEVO -->
    <a href="<?php echo e(url('/administradores/crear')); ?>" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-bold rounded-xl text-sm px-5 py-3 shadow-md transition-all flex items-center justify-center gap-2">
        <i class="bi bi-person-plus-fill text-lg"></i> Registrar Nuevo Administrador
    </a>
</div>

<!-- TABLA DE ADMINISTRADORES (ESTRUCTURA DE DISEÑO) -->
<div class="relative overflow-x-auto shadow-md sm:rounded-2xl border border-gray-100 bg-white">
    <table class="w-full text-sm text-left text-gray-600">
        <thead class="text-xs text-blue-900 uppercase bg-blue-50/70 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-black">Id</th>
                <th scope="col" class="px-6 py-4 font-black">Nombre</th>
                <th scope="col" class="px-6 py-4 font-black">Apellido</th>
                <th scope="col" class="px-6 py-4 font-black">Usuario</th>
                <th scope="col" class="px-6 py-4 font-black">Correo</th>
                <th scope="col" class="px-6 py-4 font-black">Contraseña</th>
                <th scope="col" class="px-6 py-4 font-black">Imagen</th>
                <th scope="col" class="px-6 py-4 font-black">Rol</th>
                <th scope="col" class="px-6 py-4 font-black">Estado</th>
                <th scope="col" class="px-6 py-4 font-black text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>

            <!-- SIN DATOS CARGADOS (PURO DISEÑO) -->
            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
           <?php if(session('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

            <tr>
                
                <td class="px-4 py-3">
                    <?php echo e($admin->nombre); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->nombre); ?>

                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->id); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->nombre); ?>

                </td>

               <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->Apellidos); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->usuario); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->correo); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->contraseña); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->imagen); ?>

                </td>

                <td class="px-4 py-3 hidden md:table-cell">
                    <?php echo e($admin->nombre); ?>

                </td>

            </tr>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('plantilla.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\5aCIOA\resources\views//administradores/listado.blade.php ENDPATH**/ ?>