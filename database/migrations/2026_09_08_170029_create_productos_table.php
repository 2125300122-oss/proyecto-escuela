<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // ID único del producto/medicamento

            // Campos básicos del producto
            $table->string('nombre'); // Nombre comercial
            $table->text('descripcion'); // Detalles del medicamento

            // Llaves foráneas (Clasificación triple)
            $table->foreignId('categoria_id')
                  ->constrained('categorias')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); // Relación con el uso médico

            $table->foreignId('tipo_id')
                  ->constrained('tipos')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); // Relación con la forma (Tableta, etc)

            $table->foreignId('marca_id')
                  ->constrained('marcas')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); // Relación con el fabricante

            // Precios y Stock
            $table->decimal('precio', 10, 2); // Precio de venta final
            $table->integer('existencia'); // Cantidad actual disponible
            $table->decimal('descuento', 10, 2)->default(0); // Porcentaje o monto de descuento

            // Recursos visuales
            $table->string('imagen1'); // Foto frontal
            $table->string('imagen2'); // Foto lateral o trasera
            $table->string('imagen3'); // Foto adicional

            // Estado y control
            $table->boolean('estado')->default(1); // ¿Producto visible en tienda?
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
