<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marca extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'marcas';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre',
        'imagen',
        'estado',
    ];

    /**
     * Conversión de tipos de atributos (Casting).
     */
    protected $casts = [
        'estado' => 'boolean',
    ];

    /**
     * Relación: Una marca tiene muchos productos.
     */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'marca_id');
    }
}
