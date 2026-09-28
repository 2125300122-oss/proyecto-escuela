<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductoPedido extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'productos_pedidos';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio',
        'descuento',
    ];

    /**
     * Conversión de tipos de atributos (Casting).
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
    ];

    /**
     * Relación: El detalle pertenece a un pedido.
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    /**
     * Relación: El detalle pertenece a un producto.
     */
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
