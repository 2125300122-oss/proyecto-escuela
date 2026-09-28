<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'empleados';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'usuario',
        'contraseña',
        'imagen',
        'puesto',
        'estado',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     */
    protected $hidden = [
        'contraseña',
    ];

    /**
     * Conversión de tipos de atributos (Casting).
     */
    protected $casts = [
        'estado' => 'boolean',
    ];
}
