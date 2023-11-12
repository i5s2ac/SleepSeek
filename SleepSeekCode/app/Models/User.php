<?php

namespace App\Models;

use App\Models\DetalleUsuario;
use App\Models\JobsModel;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Cupon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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

    /**
     * Obtener los detalles asociados al usuario.
     */

    public function detalleUsuario()
    {
        return $this->hasOne(DetalleUsuario::class, 'correo', 'email');
    }

    public function ReservaUsuario()
    {
        return $this->hasOne(ReservaModel::class, 'correo_creador', 'email');
    }

    public function cupones()
    {
        return $this->hasMany(Cupon::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function camposFaltantes()
    {
        $detalles = $this->detalleUsuario;
        $camposFaltantes = [];

        $campos = ['DPI', 'direction', 'number', 'avatar', 'birthday', 'gender', 'country'];

        foreach ($campos as $campo) {
            if (empty($detalles->$campo)) {
                $camposFaltantes[] = $campo;
            }
        }

        return $camposFaltantes;
    }

}