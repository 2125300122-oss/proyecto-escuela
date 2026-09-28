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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); // Folio o identificador de la venta

            // Relación con el cliente
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Datos financieros y temporales
            $table->dateTime('fecha'); // Fecha exacta de la compra
            $table->decimal('iva', 10, 2); // Impuesto aplicado
            $table->decimal('descuento', 10, 2); // Descuento global
            $table->decimal('total', 10, 2); // Monto final pagado

            // Estado de la transacción
            $table->string('estado'); // Pendiente, Pagado, Cancelado
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
