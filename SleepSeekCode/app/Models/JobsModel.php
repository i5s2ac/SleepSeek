<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsModel extends Model
{
    
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue las convenciones de Laravel
    protected $table = 'jobs';

    // Definir los campos que serán asignables masivamente
    protected $fillable = [
        'correo_creador',
        "title", 
        "description",
        "location",
        "start_date",
        "end_date",
        "status",
    ];

    /**
     * Obtener el usuario asociado a los detalles.
     */
    public function user_jobs()
    {
        return $this->belongsTo(User::class, 'correo_creador', 'email');
    }
}

