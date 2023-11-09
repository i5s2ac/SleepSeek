<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Solicitud;

class SolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Asegúrate de tener suficientes usuarios y reservas antes de ejecutar esto
        // Puedes ajustar el número en count() según tus necesidades
        Solicitud::factory()->count(10)->create();
    }
}
