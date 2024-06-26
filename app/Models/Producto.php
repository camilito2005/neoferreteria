<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $precio
 * @property $stock
 * @property $categoria_pruducto
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{

    static $rules = [
		'nombre' => 'required',
        'marca' => 'required',
		'descripcion' => 'required',
		'precio' => 'required',
        // 'categoria_producto' => 'required', 
		'stock' => 'required',

    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'marca', 'descripcion','precio','stock', 'imagen'];

    //use HasFactory;

}
