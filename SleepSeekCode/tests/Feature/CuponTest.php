<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cupon;
use App\Models\User;

class CuponTest extends TestCase
{
    use RefreshDatabase;

    public function testUserRelation()
    {
        // Crea un usuario y un post relacionado con ese usuario
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        // Obtiene el usuario relacionado a través de la relación user()
        $relatedUser = $cupon->user;

        // Asegura que el usuario relacionado sea una instancia de la clase User
        $this->assertInstanceOf(User::class, $relatedUser);

        // Asegura que el ID del usuario relacionado coincida con el ID del usuario creado
        $this->assertEquals($user->id, $relatedUser->id);
    }
}
