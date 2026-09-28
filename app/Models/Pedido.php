<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'pedidos';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'cliente_id',
        'fecha',
        'iva',
        'descuento',
        'total',
        'estado',
    ];

    /**
     * Conversión de tipos de atributos (Casting).
     */
    protected $casts = [
        'fecha' => 'datetime',
        'iva' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Relación: Un pedido pertenece a un cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relación: Un pedido tiene muchos productos asociados (detalles).
     */
    public function productos_pedido(): HasMany
    {
        return $this->hasMany(ProductoPedido::class, 'pedido_id');
    }
}
