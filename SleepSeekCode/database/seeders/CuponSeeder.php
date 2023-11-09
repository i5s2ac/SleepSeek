<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cupon; // Asegúrate de que el espacio de nombres de tu modelo Cupon sea correcto

class CuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Decide cuántos cupones deseas crear, por ejemplo, 50.
        Cupon::factory()->count(10)->create();
    }
}
