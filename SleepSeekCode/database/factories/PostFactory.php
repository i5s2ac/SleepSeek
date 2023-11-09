<?php

namespace Database\Factories;

use App\Models\Post; // Cambia esto por el espacio de nombres correcto de tu modelo
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class; // Cambia esto por el modelo correcto

    public function definition()
    {
        if (User::count() == 0) {
            User::factory()->create();
        }

        $user = User::inRandomOrder()->first();

        return [
            'PostName' => $this->faker->words(3, true), // Genera un título aleatorio
            'PostInfo' => $this->faker->paragraph, // Genera información aleatoria
            'user_id' => $user->id // Asigna el ID de un usuario existente
        ];
    }
}
