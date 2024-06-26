<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Usuarios_empleado;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function usuarioEmpleado()
    {
        return $this->hasOne(Usuarios_empleado::class, 'identificador_admin', 'identificador');
    }
    static $rules = [
        'name ' => 'required',
        'email' => 'required',
        'rol' => 'required',
        'identificador' => 'required',
        'password' => 'required',
    ];
    protected $fillable = [
        'name',
        'email',
        'rol',
        'identificador',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }
    public function isEmpleado()
    {
        return $this->rol === 'empleado';
    }
    public function yo()
    {
        return $this->rol === 'yo';
    }
    public function isUsuario()
    {
        return $this->rol === 'usuario';
    }
}
