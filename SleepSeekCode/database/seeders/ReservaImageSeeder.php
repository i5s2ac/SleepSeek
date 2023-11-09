<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReservaModel;
use App\Models\ReservaImage;

class ReservaImageSeeder extends Seeder
{
    public function run()
{
    // Crear 10 trabajos y por cada trabajo, crear una imagen asociada:
    for ($i = 0; $i < 5; $i++) {
        $reserva = ReservaModel::factory()->create(); // Crear un Job

        ReservaImage::factory()->create([
            'reserva_id' => $reserva->id // Asociar la imagen creada con el Job recién creado
        ]);
    }
}

}