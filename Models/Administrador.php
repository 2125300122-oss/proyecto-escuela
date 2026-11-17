<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'usuario',
        'contraseña',
        'rol',
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
