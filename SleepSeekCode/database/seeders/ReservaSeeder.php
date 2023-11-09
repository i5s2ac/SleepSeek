<?php

namespace Database\Seeders;

use App\Models\ReservaModel;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    public function run()
    {
        // Crear 10 trabajos usando la factory
        ReservaModel::factory(1)->create();
    }
}
