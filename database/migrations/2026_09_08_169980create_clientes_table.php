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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id(); // Identificador del cliente

            // Datos personales del cliente
            $table->string('nombres'); // Nombre(s)
            $table->string('apellidos'); // Apellido(s)
            $table->string('correo')->unique(); // Email único para login
            $table->string('contraseña'); // Password cifrada
            $table->text('direccion'); // Dirección de entrega
            $table->string('imagen'); // Foto de perfil

            // Estado y control
            $table->boolean('estado')->default(1); // ¿Usuario activo?
            $table->timestamps(); // Registros de tiempo
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
