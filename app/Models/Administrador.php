<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrador extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tabla asociada al modelo.
     
    protected $table = 'administradores';

    // Atributos que se pueden asignar masivamente.
    
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'usuario',
        'contraseña',
        'imagen',
        'rol',
        'estado',
        'activo',
    ];

    //  Atributos que deben ocultarse para la serialización.
     
    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    //  Conversión de tipos de atributos.
     
    protected $casts = [
        'estado' => 'integer',
    ];

    //  IMPORTANTE: Nombre de la columna de clave en la BD.
     
    public function getAuthPasswordName()
    {
        return 'contraseña';
    }

    

    //   Mapeamos explícitamente para que Laravel utilice 'contraseña'.
     
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    
    //   Atributo dinámico 'activo' para compatibilidad con la validación de estado activo.
     
    public function getActivoAttribute()
    {
        return $this->attributes['estado'] ?? $this->attributes['activo'] ?? 1;
    }
}
