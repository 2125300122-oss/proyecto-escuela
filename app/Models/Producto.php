<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     */
    protected $table = 'productos';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id',
        'tipo_id',
        'marca_id',
        'precio',
        'existencia',
        'descuento',
        'imagen1',
        'imagen2',
        'imagen3',
        'estado',
    ];

    /**
     * Conversión de tipos de atributos (Casting).
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'descuento' => 'decimal:2',
        'estado' => 'boolean',
    ];

    /**
     * Relación: Un producto pertenece a una categoría.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación: Un producto pertenece a un tipo.
     */
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    /**
     * Relación: Un producto pertenece a una marca.
     */
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    /**
     * Relación: Un producto puede estar en muchos detalles de pedido.
     */
    public function detalles_pedido(): HasMany
    {
        return $this->hasMany(ProductoPedido::class, 'producto_id');
    }
}
