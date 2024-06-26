<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property $id
 * @property $categoria_producto
 * @property $created_at
 * @property $updated_at
 *
 **/
 
class Category extends Model
{
    use HasFactory;
    // public function categories(){
    //     return $this->belongsToMany(Producto::class);
    // }
}
