<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Asegúrate de que los IDs de reserva correspondan a reservas existentes en la base de datos
        DB::table('reserva_images')->insert([
            [
                'reserva_id' => 1, // Asegúrate de que esta reserva exista
                'image_path' => 'https://img.freepik.com/foto-gratis/pequeno-interior-habitacion-hotel-cama-doble-bano_1262-12489.jpg?w=1800&t=st=1700026572~exp=1700027172~hmac=17eddf79b0cf6101d6e675c1c6ea37091b6c7d032a0257a07b566dfcce0a02c9',
            ],
            [
                'reserva_id' => 2, // Asegúrate de que esta reserva exista
                'image_path' => 'https://img.freepik.com/foto-gratis/diseno-apartamento-estudio-moderno-dormitorio-sala-estar_1262-12375.jpg?t=st=1700026572~exp=1700027172~hmac=522fbd14b7941160ed3000bd2fb8f304ee60a54b1955fc762af71726e794c6fb',
            ],
            [
                'reserva_id' => 3, // Asegúrate de que esta reserva exista
                'image_path' => 'https://as2.ftcdn.net/v2/jpg/06/21/01/55/1000_F_621015575_oV99ClShTkdaBqAHmU4gyIMG1kYU6W3q.jpg',
            ],
        ]);
    }
}
