<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ReservasTableSeeder::class,
            SolicitudesTableSeeder::class,
            ImageReservaSeeder::class,
            DetallesUsuarioSeeder::class,

            



            // ... agregar todos los otros seeders que tengas
        ]);
    }
}
