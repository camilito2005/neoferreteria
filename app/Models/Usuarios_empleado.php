<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property $id
 * @property $nombre_admin
 * @property $nombre_empleado
 * @property $identificador_admin
 *  */ 


class Usuarios_empleado extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'identificador_admin', 'identificador');
    }
}
