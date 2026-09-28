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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id(); // ID autoincremental de la tabla

            // Campos básicos de la categoría
            $table->string('nombre')->unique(); // Nombre único de la categoría (ej. Analgésicos)
            $table->string('imagen'); // Ruta de la imagen representativa

            // Estado y control
            $table->boolean('estado')->default(1); // Control de activación (1: Activo, 0: Inactivo)
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
