<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'PostName',
        'PostInfo',
        'user_id',
    ];

    /**
     * Obtener el usuario que creó el post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
