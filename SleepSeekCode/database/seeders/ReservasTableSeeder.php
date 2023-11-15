<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate de que esta línea esté aquí
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class ReservasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insertar datos en la tabla reservas
        DB::table('reservas')->insert([
            [
                'id' => 1,
                'correo_creador' => 'danielhidalgo@ufm.edu',
                'title' => 'Hotel El Faro',
                'description' => '¡Bienvenido a Hotel El Faro, esperamos que disfrute de una estadía inolvidable con nosotros! Solamente por $999 la noche.',
                'location' => 'Carretera al Salvador, km 19.5 en Plaza El Faro, Ciudad de Guatemala.',
                'start_date' => Carbon::parse('2023-05-28'),
                'end_date' => Carbon::parse('2023-05-29'),
                'status' => 'Disponible',
                'boost' => true,
            ],
            [
                'id' => 2,
                'correo_creador' => 'luismorales@ufm.edu',
                'title' => 'Hotel El Roble',
                'description' => '¡Bienvenido a Hotel El Roble, esperamos que disfrute de una estadía inolvidable con nosotros! Solamente por $999 la noche.',
                'location' => 'Carretera a San Lucas, km 19.5 en Plaza El Roble, Sacatepéquez.',
                'start_date' => Carbon::parse('2023-07-02'),
                'end_date' => Carbon::parse('2023-07-03'),
                'status' => 'Disponible',
                'boost' => true,
            ],
            [
                'id' => 3,
                'correo_creador' => 'isaaccyrman@ufm.edu',
                'title' => 'Hotel El Castro',
                'description' => '¡Bienvenido a Hotel El Castro, esperamos que disfrute de una estadía inolvidable con nosotros! Solamente por $999 la noche.',
                'location' => 'Carretera a Peten, km 22.5 en Plaza El Castro, Peten.',
                'start_date' => Carbon::parse('2023-09-03'),
                'end_date' => Carbon::parse('2023-09-04'),
                'status' => 'Disponible',
                'boost' => true,
            ],
        ]);
    }
}
