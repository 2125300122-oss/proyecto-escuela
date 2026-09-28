@extends('layouts/app')

@section('contenido')
<div>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md border-t-4 border-blue-600">
        <h2 class="mb-6 text-xl font-bold text-[#000d5e] dark:text-white sm:text-2xl">Editar Medicamento / Producto</h2>

        <form action="/productos/actualizar" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Comercial</label>
                    <input type="text" id="nombre" name="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div class="sm:col-span-2">
                    <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción / Fórmula</label>
                    <textarea id="descripcion" name="descripcion" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required></textarea>
                </div>

                <div>
                    <label for="precio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio ($ MXN)</label>
                    <input type="number" step="0.01" id="precio" name="precio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div>
                    <label for="existencia" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Existencia en Stock</label>
                    <input type="number" id="existencia" name="existencia" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Actualizar Producto</button>
        </form>
    </div>
</div>
@endsection
