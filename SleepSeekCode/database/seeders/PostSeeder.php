<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post; // Asegúrate de que el espacio de nombres de tu modelo Post sea correcto

class PostSeeder extends Seeder
{
    public function run()
    {
        // Decides cuántas publicaciones quieres crear
        Post::factory()->count(10)->create();
    }
}
