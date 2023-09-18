<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaImage extends Model
{
    use HasFactory;

    // Define la tabla si no sigue las convenciones de Laravel
    protected $table = 'reserva_images';

    // Definir los campos que serán asignables masivamente
    protected $fillable = [
        'filename', 
        'reserva_id',
    ];

    /**
     * Obtener la reserva asociada a esta imagen.
     */
    public function reserva()
    {
        return $this->belongsTo(ReservaModel::class, 'reserva_id');
    }
}
