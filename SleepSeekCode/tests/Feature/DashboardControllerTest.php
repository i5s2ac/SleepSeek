<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ReservaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_view_response()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        // Crea reservas para otro usuario
        ReservaModel::factory()->create([
            'correo_creador' => $anotherUser->email,
        ]);

        $this->actingAs($user);

        $response = $this->get('/dashboard'); // Asumiendo que la ruta al dashboard es '/dashboard'

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHas('reservas');
    }

    public function test_dashboard_json_response()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        // Crea reservas para otro usuario
        ReservaModel::factory()->create([
            'correo_creador' => $anotherUser->email,
        ]);

        $this->actingAs($user);

        $response = $this->json('GET', '/dashboard');

        $response->assertStatus(200);
        $response->assertJsonStructure([/* Estructura del JSON esperado */]);
    }

}
