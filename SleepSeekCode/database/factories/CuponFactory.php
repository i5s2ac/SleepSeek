<?php

namespace Database\Factories;

use App\Models\Cupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CuponFactory extends Factory
{
    protected $model = Cupon::class;

    public function definition()
    {
        return [
            'codigo' => $this->faker->unique()->bothify('CUPON-####'), // Genera un código único
            'descuento' => $this->faker->randomFloat(2, 0, 100), // Suponiendo que es un porcentaje entre 0 y 100
            'fecha_expiracion' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'), // Fecha de expiración en algún momento dentro de los próximos dos años
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? null, // ID de usuario aleatorio, o null si no hay usuarios
        ];
    }
}
