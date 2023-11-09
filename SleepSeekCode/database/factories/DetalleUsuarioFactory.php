<?php

namespace Database\Factories;

use App\Models\DetalleUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DetalleUsuarioFactory extends Factory
{
    protected $model = DetalleUsuario::class;

    public function definition()
    {
        $links = [
            'https://img.freepik.com/foto-gratis/imagen-elegante-gerente-joven-piel-oscura-cardigan-amarillo-sosteniendo-computadora-portatil-generica-dejando-oficina-despues-trabajo-concepto-personas-tecnologia-moderna-trabajo-ocupacion-aparatos-electronicos_343059-1565.jpg',
            "https://img.freepik.com/foto-gratis/concepto-personas-estilo-vida-tecnologia-moderna-trabajo-comunicacion-atractiva-joven-autonoma-piel-oscura-cabello-rizado-mirada-complacida-disfrutando-trabajo-distante-usando-laptop-generica_343059-1631.jpg",
            "https://img.freepik.com/foto-gratis/varon-joven-piel-oscura-cabello-rizado-rodeado-libros-telefono-mano-mirando-computadora-portatil-sonrisa-feliz-encontrar-lo-que-necesita-proyecto-gente-juventud-educacion_273609-7508.jpg",
        ];

        // Puedes obtener un correo electrónico y DPI únicos por cada llamada a la función
        // o gestionarlo mediante un estado de la fábrica para asegurar la relación con un usuario existente.
        $correo = $this->faker->unique()->safeEmail;
        $dpi = $this->faker->unique()->numerify('#########');

        return [
            'correo' => $correo, // Asegúrate de que este correo coincida con uno de la tabla de usuarios.
            'avatar' => $this->faker->randomElement($links),
            'number' => $this->faker->unique()->tollFreePhoneNumber,
            'birthday' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']), // Adapta según tus necesidades.
            'country' => $this->faker->country,
            'direction' => $this->faker->address,
            'dpi_photo' => $this->faker->imageUrl(), // Suponiendo que se guarda una URL de la imagen.
            'DPI' => $dpi,
        ];
    }
}
