<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ReservaImage;
use App\Models\ReservaModel;

class ReservaImageTest extends TestCase
{
    use RefreshDatabase;

    public function testReservaRelation()
    {
        // Crea una reserva y una imagen relacionada con esa reserva
        $reserva = ReservaModel::factory()->create();
        $reservaImage = ReservaImage::factory()->create(['reserva_id' => $reserva->id]);

        // Obtiene la reserva relacionada a través de la relación reserva()
        $relatedReserva = $reservaImage->reserva;

        // Asegura que la reserva relacionada sea una instancia de la clase ReservaModel
        $this->assertInstanceOf(ReservaModel::class, $relatedReserva);

        // Asegura que el ID de la reserva relacionada coincida con el ID de la reserva creada
        $this->assertEquals($reserva->id, $relatedReserva->id);
    }
}
