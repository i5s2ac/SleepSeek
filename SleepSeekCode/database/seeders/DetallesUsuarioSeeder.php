<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DetallesUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detalles_usuario')->insert([
            [
                "id" => '1',
                'correo' => 'isaaccyrman@ufm.edu',
                'avatar' => 'https://img.freepik.com/foto-gratis/hombre-negocios-joven-hermoso-serio-que-ajusta-vidrios-que-sostiene-carpeta_1262-14365.jpg?t=st=1700026572~exp=1700027172~hmac=fe4d2a23a6c4de1f9f6481c328402b3dd7777b7080103d097a54db83e95198ff',
                'number' => '59227983',
                'birthday' => Carbon::createFromDate(1990, 1, 1),
                'gender' => 'masculino',
                'country' => 'Guatemala',
                'direction' => 'Carretera al Salvador',
                'dpi_photo' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'DPI' => '4009363640101',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "id" => '2',
                'correo' => 'danielhidalgo@ufm.edu',
                'avatar' => 'https://paulafotografia.com/wp-content/uploads/2021/11/DSC_2096_PF.jpg',
                'number' => '59227984',
                'birthday' => Carbon::createFromDate(1990, 1, 1),
                'gender' => 'masculino',
                'country' => 'Guatemala',
                'direction' => 'Carretera al Salvador',
                'dpi_photo' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'DPI' => '4009363640102',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                "id" => '3',
                'correo' => 'luismorales@ufm.edu',
                'avatar' => 'https://img.freepik.com/foto-gratis/hombre-negocios-fumando-sobre-fondo-blanco-aislado_1368-6440.jpg',
                'number' => '59227987',
                'birthday' => Carbon::createFromDate(1990, 1, 1),
                'gender' => 'masculino',
                'country' => 'Guatemala',
                'direction' => 'Carretera al Salvador',
                'dpi_photo' => "https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf",
                'DPI' => '4009363540109',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
