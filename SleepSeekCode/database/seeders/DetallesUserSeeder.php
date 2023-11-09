<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetalleUsuario;
use App\Models\User;


class DetallesUserSeeder extends Seeder
{
    public function run()
    {
        // Crear un usuario y luego su detalle
        $user = User::factory()->create();
        DetalleUsuario::factory()->create(['correo' => $user->email]);

        // Crear 2 usuarios y sus detalles
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()->create();
            DetalleUsuario::factory()->create(['correo' => $user->email]);
        }

        // Generar una instancia sin guardarla en la base de datos (útil para pruebas)
        // Esto solo genera el detalle, no se asocia con ningún usuario ni se guarda
        $detalleUsuario = DetalleUsuario::factory()->make();
    }

}
