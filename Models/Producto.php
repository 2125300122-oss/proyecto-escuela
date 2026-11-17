<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
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
        'estado'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'existencia' => 'integer',
        'descuento' => 'decimal:2',
        'estado' => 'boolean'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
