<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $fillable = [
        'correo',
        "avatar", 
        "number",
        "birthday",
        "gender",
        "country",
        "direction",
        "dpi_photo",
        "DPI",
        "estado"
    ];

    public function reserva()
    {
        return $this->belongsTo(ReservaModel::class, 'reserva_id');
    }

}
