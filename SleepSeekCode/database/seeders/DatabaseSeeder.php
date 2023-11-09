<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DetallesUserSeeder::class,
            ReservaSeeder::class,
            ReservaImageSeeder::class,
            SolicitudSeeder::class,
            CuponSeeder::class,
            PostSeeder::class,



            // ... agregar todos los otros seeders que tengas
        ]);
    }
}
