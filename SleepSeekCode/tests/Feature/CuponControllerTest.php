<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Cupon;

class CuponControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsJson()
    {
        $user = User::factory()->create();
        Cupon::factory()->create(['user_id' => $user->id]);
    
        $response = $this->actingAs($user)->getJson(route('cupones.index'));
    
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => [
                         'id', 
                         'codigo', 
                         'descuento', 
                         'fecha_expiracion'
                     ]
                 ]);
    }
 
    public function testIndexReturnsView()
    {
        $user = User::factory()->create();
        Cupon::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('cupones.index'));

        $response->assertStatus(200)
                ->assertViewIs('cupones.index')
                ->assertViewHas('cupones');
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('cupones.create'));

        $response->assertStatus(200);
        $response->assertViewIs('cupones.create');
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $cuponData = [
            'codigo' => 'UNICO123',
            'descuento' => "10",
            'fecha_expiracion' => now()->addDays(10)->format('Y-m-d')
        ];

        $response = $this->actingAs($user)->post(route('cupones.store'), $cuponData);

        $response->assertRedirect(route('cupones.index'));
        $this->assertDatabaseHas('cupones', ['codigo' => 'UNICO123']);
    }

    public function testStoreReturnsJson()
    {
        $user = User::factory()->create();
        $fechaExpiracion = now()->addDays(10)->format('Y-m-d');
        $cuponData = [
            'codigo' => 'UNICO123',
            'descuento' => 10,
            'fecha_expiracion' => $fechaExpiracion
        ];
    
        $response = $this->actingAs($user)->postJson(route('cupones.store'), $cuponData);
    
        $response->assertStatus(200)
                ->assertJson([
                    'codigo' => 'UNICO123', 
                    'descuento' => 10,
                    'fecha_expiracion' => $fechaExpiracion . 'T00:00:00.000000Z' // Ajusta el formato para coincidir con la respuesta
                ]);
    }
    
    


    public function testShow()
    {
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('cupones.show', $cupon));

        $response->assertStatus(200);
        $response->assertViewIs('cupones.show');
    }

    public function testShowWithoutPermission()
    {
        // Usuario con permiso
        $userWithPermission = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $userWithPermission->id]);

        // Usuario sin permiso
        $userWithoutPermission = User::factory()->create();

        // Actuando como el usuario sin permiso
        $response = $this->actingAs($userWithoutPermission)->get(route('cupones.show', $cupon));

        // Verificar que se recibe un error 403 Forbidden
        $response->assertStatus(403);
    }


    public function testEdit()
    {
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('cupones.edit', $cupon));

        $response->assertStatus(200);
        $response->assertViewIs('cupones.edit');
    }

    public function testEditWithoutPermission()
    {
        // Usuario propietario del cupón
        $ownerUser = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $ownerUser->id]);

        // Usuario no propietario
        $nonOwnerUser = User::factory()->create();

        // Actuando como el usuario no propietario
        $response = $this->actingAs($nonOwnerUser)->get(route('cupones.edit', $cupon));

        // Verificar que se recibe un error 403 Forbidden
        $response->assertStatus(403);
    }


    public function testUpdate()
    {
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'codigo' => 'UPDATE123',
            'descuento' => 15,
            'fecha_expiracion' => now()->addDays(15)->format('Y-m-d')
        ];

        $response = $this->actingAs($user)->patch(route('cupones.update', $cupon), $updateData);

        $response->assertRedirect(route('cupones.index'));
        $this->assertDatabaseHas('cupones', ['codigo' => 'UPDATE123']);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('cupones.destroy', $cupon));

        $response->assertRedirect(route('cupones.index'));
        $this->assertDatabaseMissing('cupones', ['id' => $cupon->id]);
    }

    public function testDestroyReturnsJson()
    {
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        // Asegúrate de que la solicitud acepta JSON
        $response = $this->actingAs($user)->deleteJson(route('cupones.destroy', $cupon));

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $cupon->id,
                    // Otros campos del cupón si los necesitas
                ]);

        $this->assertDatabaseMissing('cupones', ['id' => $cupon->id]);
    }

}
