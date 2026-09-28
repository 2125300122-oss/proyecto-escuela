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
        Schema::create('marcas', function (Blueprint $table) {
            $table->id(); // ID autoincremental de la tabla

            // Información del fabricante o laboratorio
            $table->string('nombre')->unique(); // Ej. Bayer, Pfizer, Genomma Lab
            $table->string('imagen'); // Logo del fabricante

            // Estado y control
            $table->boolean('estado')->default(1); // Control de activación
            $table->timestamps(); // Registros de tiempo
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};
