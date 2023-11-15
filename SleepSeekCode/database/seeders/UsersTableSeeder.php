<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            ['id' => 1, "name" => "Isaac Cyrman" ,'email' => 'isaaccyrman@ufm.edu', 'password' => bcrypt('Isaac123!'), 'created_at' => Carbon::parse('2023-11-15 03:36:57')],
            ['id' => 2, "name" => "Daniel Hidalgo", 'email' => 'danielhidalgo@ufm.edu', 'password' => bcrypt('Daniel123!'), 'created_at' => Carbon::parse('2023-11-15 03:36:57')],
            ['id' => 3, "name" => "Luis Morales", 'email' => 'luismorales@ufm.edu', 'password' => bcrypt('Luis123!'), 'created_at' => Carbon::parse('2023-11-15 03:36:57')],
        ]);
        
    }
}
