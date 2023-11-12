<?php
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\DetalleUsuario;
use App\Models\User;

class DetalleUsuarioTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRelationWithCustomKeys()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $detalleUsuario = DetalleUsuario::factory()->create(['correo' => $user->email]);

        $relatedUser = $detalleUsuario->user;

        $this->assertInstanceOf(User::class, $relatedUser);
        $this->assertEquals($user->email, $relatedUser->email);
    }

}
