<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Proveedor
 *
 * @property $id
 * @property $nombre
 * @property $direccion
 * @property $numero
 * @property $correo
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Proveedor extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'direccion' => 'required',
		'numero' => 'required',
		'correo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','direccion','numero','correo'];



}
