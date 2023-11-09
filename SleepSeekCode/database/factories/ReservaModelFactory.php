<?php

namespace Database\Factories;

use App\Models\ReservaModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservaModelFactory extends Factory
{
    protected $model = ReservaModel::class;

    public function definition()
    {
        // Asegúrate de que hay al menos un usuario para evitar un error
        if (User::count() == 0) {
            User::factory()->create();
        }

        $user = User::inRandomOrder()->first(); // Obtener un usuario al azar

        return [
            'correo_creador' => $user->email, // Asume que siempre habrá al menos un usuario
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph(3),
            'location' => $this->faker->address,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => 'disponible', // Valor por defecto especificado en la migración
            'boost' => $this->faker->boolean(false), // Valor por defecto falso, opcional
        ];
    }
}
