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
        Schema::create('productos_pedidos', function (Blueprint $table) {
            $table->id(); // Identificador del registro detalle

            // Relaciones
            $table->foreignId('pedido_id')
                  ->constrained('pedidos')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreignId('producto_id')
                  ->constrained('productos')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Información específica del producto en ese momento
            $table->integer('cantidad'); // Cantidad comprada
            $table->decimal('precio', 10, 2); // Precio unitario registrado al momento
            $table->decimal('descuento', 10, 2); // Descuento aplicado por unidad

            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_pedidos');
    }
};
