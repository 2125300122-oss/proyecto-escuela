<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'clientes';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'contraseña',
        'direccion',
        'imagen',
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

    /**
     * Relación: Un cliente tiene muchos pedidos.
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'cliente_id');
    }
}
