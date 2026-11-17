<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'usuario',
        'contraseña',
        'puesto',
        'imagen',
        'estado'
    ];

    protected $hidden = [
        'contraseña'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];
}
