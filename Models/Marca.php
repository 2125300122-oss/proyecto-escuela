<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = [
        'nombre',
        'imagen',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];
}
