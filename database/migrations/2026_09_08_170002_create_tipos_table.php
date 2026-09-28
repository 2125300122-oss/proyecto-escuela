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
        Schema::create('tipos', function (Blueprint $table) {
            $table->id(); // ID autoincremental de la tabla

            // Clasificación por forma farmacéutica
            $table->string('nombre')->unique(); // Ej. Tabletas, Jarabe, Suspensión
            $table->string('imagen'); // Icono o foto del tipo de presentación

            // Estado y control
            $table->boolean('estado')->default(1); // Control de visibilidad
            $table->timestamps(); // Registros de tiempo
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos');
    }
};
