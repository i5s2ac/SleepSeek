<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Solicitud;
use App\Models\ReservaModel; // Asegúrate de que esta línea refleje la ubicación real del modelo ReservaModel
use Illuminate\Foundation\Testing\RefreshDatabase;

class SleepInControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexViewResponse()
    {
        // Crear usuarios
        $reservaUser = User::factory()->create(); // Usuario que crea la reserva
        $otherUser = User::factory()->create(); // Otro usuario

        // Crear reserva asociada al primer usuario
        $reserva = ReservaModel::factory()->create(['correo_creador' => $reservaUser->email]);

        // Crear solicitudes para el otro usuario
        Solicitud::factory()->count(3)->create(['correo' => $otherUser->email, 'reserva_id' => $reserva->id]);

        // Autenticar como el otro usuario
        $this->actingAs($otherUser);

        // Realizar petición HTTP
        $response = $this->get('/SleepIn');
        $response->assertStatus(200);
        $response->assertViewIs('SleepIn');
        $response->assertViewHas('solicitudes');
    }

    public function testIndexJsonResponse()
    {
        // Crear usuarios
        $reservaUser = User::factory()->create();
        $otherUser = User::factory()->create();

        // Crear reserva asociada al primer usuario
        $reserva = ReservaModel::factory()->create(['correo_creador' => $reservaUser->email]);

        // Crear solicitudes para el otro usuario
        $solicitudes = Solicitud::factory()->count(3)->create(['correo' => $otherUser->email, 'reserva_id' => $reserva->id]);

        // Autenticar como el otro usuario
        $this->actingAs($otherUser);

        // Realizar petición HTTP solicitando JSON
        $response = $this->json('GET', '/SleepIn');

        $response->assertStatus(200); // Verifica que el código de estado sea 200
        $response->assertJson($solicitudes->toArray()); // Verifica que el JSON devuelto contiene las solicitudes
    }

    public function testEliminarSolicitudHtmlResponse()
    {
        $reservaUser = User::factory()->create();
        $reserva = ReservaModel::factory()->create(['correo_creador' => $reservaUser->email]);

        // Crear usuarios adicionales
        $additionalUsers = User::factory()->count(3)->create();

        $solicitud = Solicitud::factory()->create(['reserva_id' => $reserva->id]);

        $this->actingAs($additionalUsers->first());

        $response = $this->delete("/solicitudes/{$solicitud->id}/eliminar");

        $response->assertRedirect();
        $this->assertDatabaseMissing('solicitudes', ['id' => $solicitud->id]);
        $response->assertSessionHas('success', 'Solicitud cancelada exitosamente.');
    }

    public function testEliminarSolicitudJsonResponse()
    {
        $reservaUser = User::factory()->create();
        $reserva = ReservaModel::factory()->create(['correo_creador' => $reservaUser->email]);

        // Crear usuarios adicionales
        $additionalUsers = User::factory()->count(3)->create();

        $solicitud = Solicitud::factory()->create(['reserva_id' => $reserva->id]);

        $this->actingAs($additionalUsers->first());

        $response = $this->json('DELETE', "/solicitudes/{$solicitud->id}/eliminar");

        $response->assertStatus(200);
        $response->assertJson($solicitud->toArray());
        $this->assertDatabaseMissing('solicitudes', ['id' => $solicitud->id]);
    }
    
}
