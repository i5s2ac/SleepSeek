<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsView()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.index'));

        $response->assertStatus(200)
                ->assertViewIs('posts.index')
                ->assertViewHas('posts', Post::all());
    }

    public function testIndexReturnsJson()
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('posts.index'));

        $response->assertStatus(200)
                ->assertJson(Post::all()->toArray());
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $postData = [
            'PostName' => 'Ejemplo Post',
            'PostInfo' => 'Información del post'
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', ['PostName' => 'Ejemplo Post']);
    }

    public function testShow()
    {
        // Crea un usuario y un post asociado a ese usuario
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.show', $post));

        $response->assertStatus(200);

        $response->assertViewIs('posts.show');

        $response->assertViewHas('post', $post);
    }

    public function testEdit()
    {
        // Crea un usuario y un post asociado a ese usuario
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('posts.edit', $post));

        $response->assertStatus(200);

        $response->assertViewIs('posts.edit');

        $response->assertViewHas('post', $post);
    }

    public function testUpdate()
    {
        // Crea un usuario y un post asociado a ese usuario
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'PostName' => 'Nombre Actualizado',
            'PostInfo' => 'Información actualizada del post',
        ];

        $response = $this->actingAs($user)->patch(route('posts.update', $post), $updatedData);

        $response->assertRedirect(route('posts.index'));

        $response->assertSessionHas('success', 'Post actualizado con éxito.');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'PostName' => 'Nombre Actualizado',
            'PostInfo' => 'Información actualizada del post'
        ]);
    }
    public function testStoreReturnsJson()
    {
        $user = User::factory()->create();
        $postData = [
            'PostName' => 'Ejemplo Post',
            'PostInfo' => 'Información del post'
        ];

        $response = $this->actingAs($user)->postJson(route('posts.store'), $postData);

        $response->assertStatus(200)
                ->assertJson([
                    'PostName' => 'Ejemplo Post',
                    'PostInfo' => 'Información del post'
                ]);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        $response->assertSessionHas('success', 'Post eliminado con éxito.');
    }

    public function testDestroyReturnsJson()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson(route('posts.destroy', $post));

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Post eliminado con éxito.',
                    'post_deleted' => [
                        'id' => $post->id,
                    ]
                ]);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

}
