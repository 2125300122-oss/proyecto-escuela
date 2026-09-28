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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); // Identificador del empleado

            // Información laboral y de contacto
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo')->unique();
            $table->string('usuario')->unique();
            $table->string('contraseña');
            $table->string('imagen');

            // Puesto y estado
            $table->string('puesto'); // Cargo en la farmacia
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
