<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ReservaModel;
use App\Models\User;
use App\Models\ReservaImage;
use App\Models\Solicitud;

class ReservaModelTest extends TestCase
{
    use RefreshDatabase;

    public function testUserJobsRelation()
    {
        // Crea una instancia de ReservaModel
        $reserva = ReservaModel::factory()->create();

        // Crea un usuario relacionado con la reserva
        $user = User::factory()->create(['email' => $reserva->correo_creador]);

        // Obtiene el usuario asociado a través de la relación user_jobs()
        $relatedUser = $reserva->user_jobs;

        // Asegura que la relación user_jobs() devuelva una instancia de User
        $this->assertInstanceOf(User::class, $relatedUser);

        // Asegura que el correo del usuario relacionado coincida con el correo de la reserva
        $this->assertEquals($reserva->correo_creador, $relatedUser->email);
    }

    public function testImagesRelation()
    {
        // Crea una instancia de ReservaModel
        $reserva = ReservaModel::factory()->create();

        // Crea una imagen relacionada con la reserva
        $image = ReservaImage::factory()->create(['reserva_id' => $reserva->id]);

        // Obtiene las imágenes asociadas a través de la relación images()
        $relatedImages = $reserva->images;

        // Asegura que la relación images() devuelva una colección de ReservaImage
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $relatedImages);

        // Asegura que la colección contenga la imagen relacionada
        $this->assertTrue($relatedImages->contains($image));
    }

    public function testSolicitudesRelation()
    {
        // Crea una instancia de ReservaModel
        $reserva = ReservaModel::factory()->create();
    
        // Crea usuarios adicionales
        $additionalUsers = User::factory()->count(3)->create();
    
        // Asegúrate de que exista al menos un usuario distinto al creador de la reserva
        $solicitud = Solicitud::factory()->create([
            'reserva_id' => $reserva->id, 
            'correo' => $additionalUsers->first()->email
        ]);
    
        // Obtiene las solicitudes asociadas a través de la relación solicitudes()
        $relatedSolicitudes = $reserva->solicitudes;
    
        // Asegura que la relación solicitudes() devuelva una colección de Solicitud
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $relatedSolicitudes);
    
        // Asegura que la colección contenga la solicitud relacionada verificando por el ID
        $this->assertTrue($relatedSolicitudes->pluck('id')->contains($solicitud->id));
    }
}    
