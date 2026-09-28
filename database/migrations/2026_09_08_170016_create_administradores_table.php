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
        Schema::create('administradores', function (Blueprint $table) {
            $table->id(); // ID único

            // Perfil del administrador
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo')->unique();
            $table->string('usuario')->unique(); // Nickname para acceso
            $table->string('contraseña');
            $table->string('imagen');

            // Niveles y estado
            $table->string('rol'); // Gerente, Farmacéutico, Vendedor
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
