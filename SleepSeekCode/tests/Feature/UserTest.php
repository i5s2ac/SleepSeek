<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ReservaModel;
use App\Models\DetalleUsuario;
use App\Models\Cupon; 
use App\Models\Post; 


use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testUserHasDetalleUsuario()
    {
        $user = User::factory()->create();
        $detalleUsuario = DetalleUsuario::factory()->create(['correo' => $user->email]);

        $this->assertEquals($detalleUsuario->id, $user->detalleUsuario->id);
    }

    public function testUserHasReservaUsuario()
{
    $user = User::factory()->create();
    $reserva = ReservaModel::factory()->create(['correo_creador' => $user->email]);

    $this->assertEquals($reserva->id, $user->ReservaUsuario->id);
}

public function testUserHasManyCupones()
{
    $user = User::factory()->create();
    $cupon = Cupon::factory()->count(3)->create(['user_id' => $user->id]);

    $this->assertCount(3, $user->cupones);
}

public function testUserHasManyPosts()
{
    $user = User::factory()->create();
    $posts = Post::factory()->count(2)->create(['user_id' => $user->id]);

    $this->assertCount(2, $user->posts);
}

public function testCamposFaltantes()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->create(['correo' => $user->email, 'DPI' => null]);

    $camposFaltantes = $user->camposFaltantes();

    $this->assertContains('DPI', $camposFaltantes);
}




}
