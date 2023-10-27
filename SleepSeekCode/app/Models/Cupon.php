<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;

    protected $table = 'cupones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descuento',
        'fecha_expiracion',
        'user_id', // Agregado
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'fecha_expiracion' => 'date',
    ];

    /**
     * Get the user that owns the cupon.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
