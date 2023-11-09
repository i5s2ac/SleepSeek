<?php

namespace Database\Factories;

use App\Models\Solicitud;
use App\Models\ReservaModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudFactory extends Factory
{
    protected $model = Solicitud::class;

    public function definition()
    {
        // Asegúrate de que hay al menos una reserva para evitar errores
        if (ReservaModel::count() == 0) {
            throw new \Exception("No hay reservas para crear solicitudes.");
        }

        // Obtén una reserva aleatoria
        $reserva = ReservaModel::inRandomOrder()->first();

        // Obtén todos los usuarios excepto el que creó la reserva
        $users = User::where('email', '!=', $reserva->correo_creador)->get();

        // Si no hay usuarios disponibles, lanzar una excepción o puedes optar por crear uno
        if ($users->isEmpty()) {
            throw new \Exception("No hay usuarios disponibles para crear solicitudes.");
        }

        // Selecciona un usuario aleatorio de los disponibles
        $user = $users->random();

        return [
            'reserva_id' => $reserva->id,
            'correo' => $user->email,
            'avatar' => $this->faker->imageUrl(640, 480),
            'number' => $this->faker->phoneNumber,
            'birthday' => $this->faker->date('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'country' => $this->faker->country,
            'direction' => $this->faker->address,
            'dpi_photo' => $this->faker->imageUrl(640, 480),
            'DPI' => $this->faker->numerify('##########'),
            'estado' => 'pendiente',
        ];
    }
}
