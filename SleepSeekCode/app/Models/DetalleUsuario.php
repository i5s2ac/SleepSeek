<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleUsuario extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue las convenciones de Laravel
    protected $table = 'detalles_usuario';

    // Definir los campos que serán asignables masivamente
    protected $fillable = [
        'correo',
        "avatar", 
        "number",
        "birthday",
        "gender",
        "country",
        "direction",
        "dpi_photo",
        "DPI"
    ];

    /**
     * Obtener el usuario asociado a los detalles.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'correo', 'email');
    }
}

