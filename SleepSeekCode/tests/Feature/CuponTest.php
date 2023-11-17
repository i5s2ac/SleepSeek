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
        $user = User::factory()->create();
        $cupon = Cupon::factory()->create(['user_id' => $user->id]);

        $relatedUser = $cupon->user;

        $this->assertInstanceOf(User::class, $relatedUser);

        $this->assertEquals($user->id, $relatedUser->id);
    }
}
