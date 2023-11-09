<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobImage>
 */
class ReservaImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $links = [
            'https://standards.ieee.org/wp-content/uploads/2021/12/Connected-technologies-1920x1080-1.jpg',
            //... agregar tantos enlaces como desees
        ];

        return [
            'image_path' => $links[array_rand($links)],
            // 'job_id' => Aquí no definimos esto porque lo haremos al momento de crearlo
        ];
    }
}
