<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SolicitudesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solicitudes')->insert([
            [
                'id' => 1,
                'reserva_id' => 3,
                'correo' => 'danielhidalgo@ufm.edu',
                'avatar' => 'https://paulafotografia.com/wp-content/uploads/2021/11/DSC_2096_PF.jpg',
                'number' => '59226754',
                'birthday' => Carbon::parse('2000-10-03'),
                'gender' => 'masculino',
                'country' => 'guatemala',
                'direction' => 'Zona 10, Ciudad de Guatemala.',
                'dpi_photo' => null,
                'dpi' => '4009363650203',
                'estado' => 'pendiente',
                'created_at' => Carbon::parse('2023-11-15 03:36:57'),
                'updated_at' => Carbon::parse('2023-11-15 03:36:57'),
            ],
            [
                'id' => 2,
                'reserva_id' => 3,
                'correo' => 'luismorales@ufm.edu',
                'avatar' => 'https://cdn.domestika.org/c_fill,dpr_auto,f_auto,q_auto/v1425034585/content-items/001/228/844/sesion-estudio-barcelona-10-original.jpg?1425034585',
                'number' => '59226754',
                'birthday' => Carbon::parse('2000-10-03'),
                'gender' => 'masculino',
                'country' => 'guatemala',
                'direction' => 'Zona 10, Ciudad de Guatemala.',
                'dpi_photo' => null,
                'dpi' => '4009363650203',
                'estado' => 'pendiente',
                'created_at' => Carbon::parse('2023-11-15 03:36:57'),
                'updated_at' => Carbon::parse('2023-11-15 03:36:57'),
            ],
        ]);
    }
}
