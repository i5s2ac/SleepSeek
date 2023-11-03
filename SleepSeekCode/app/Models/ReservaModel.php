<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReservaImage; 


class ReservaModel extends Model
{
    
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue las convenciones de Laravel
    protected $table = 'reservas';

    // Definir los campos que serán asignables masivamente
    protected $fillable = [
        'correo_creador',
        "title", 
        "description",
        "location",
        "start_date",
        "end_date",
        "status",
        "boost",
    ];

    /**
     * Obtener el usuario asociado a los detalles.
     */
    public function user_jobs()
    {
        return $this->belongsTo(User::class, 'correo_creador', 'email');
    }

    /**
     * Obtener las imágenes asociadas a la reserva.
     */
    public function images()
    {
        return $this->hasMany(ReservaImage::class, 'reserva_id');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'reserva_id');
    }
}

