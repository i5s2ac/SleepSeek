<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ReservaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\ReservaImage;
use App\Models\Solicitud;
use App\Models\DetalleUsuario;

class ReservaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create();
        ReservaModel::factory()->count(3)->create(['correo_creador' => $user->email]);

        $response = $this->actingAs($user)->get(route('reservas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('reservas.index');
    }

    public function testIndexReturnsJson()
    {
        $user = User::factory()->create();
        ReservaModel::factory()->count(3)->create(['correo_creador' => $user->email]);

        $response = $this->actingAs($user)->getJson(route('reservas.index'));

        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => [
                        'title', 'description', 'location', 'start_date', 'end_date', 'status', 'boost'
                    ],
                ]);
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('reservas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('reservas.create');
    }

    public function testStoreValidation()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson(route('reservas.store'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'title', 'description', 'location', 'start_date', 'end_date', 'status', 'boost'
        ]);
    }

    public function testStoreSuccessWithoutImages()
        {
            $this->actingAs(User::factory()->create());

            $reservaData = [
                "title" => "Test Title",
                "description" => "Test Description",
                "location" => "Test Location",
                "start_date" => "2023-01-01",
                "end_date" => "2023-01-05",
                "status" => "active",
                "boost" => true
            ];

            $response = $this->postJson(route('reservas.store'), $reservaData);

            $response->assertStatus(201);
            $this->assertDatabaseHas('reservas', $reservaData);
        }

        public function testStoreSuccessWithImages()
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $reservaData = [
            "title" => "Test Title",
            "description" => "Test Description",
            "location" => "Test Location",
            "start_date" => "2023-01-01",
            "end_date" => "2023-01-05",
            "status" => "active",
            "boost" => true,
            "images" => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.jpg')
            ]
        ];

        $response = $this->postJson(route('reservas.store'), $reservaData);

        $response->assertStatus(201);
        $reserva = ReservaModel::latest()->first();

        $this->assertDatabaseHas('reservas', [
            "title" => "Test Title",
            "description" => "Test Description",
            "location" => "Test Location",
            "start_date" => "2023-01-01",
            "end_date" => "2023-01-05",
            "status" => "active",
            "boost" => true,
            "images" => [
                UploadedFile::fake()->image('image1.jpg'),
                UploadedFile::fake()->image('image2.jpg')
            ]
        ]);

        foreach ($reservaData['images'] as $index => $image) {
            $expectedImageName = $reserva->created_at->timestamp . '_' . $image->getClientOriginalName();
            
            Storage::disk('public')->assertExists('images/' . $expectedImageName);

            $this->assertDatabaseHas('reserva_images', [
                'reserva_id' => $reserva->id,
                'image_path' => $expectedImageName,
            ]);
        }
    }


    public function testStoreResponseTypes()
    {
        $this->actingAs(User::factory()->create());

        $reservaData = [
            "title" => "Test Title",
            "description" => "Test Description",
            "location" => "Test Location",
            "start_date" => "2023-01-01",
            "end_date" => "2023-01-05",
            "status" => "active",
            "boost" => true
        ];

        $responseJson = $this->postJson(route('reservas.store'), $reservaData);
        $responseJson->assertStatus(201);

        $responseRedirect = $this->post(route('reservas.store'), $reservaData);
        $responseRedirect->assertStatus(302);
        $responseRedirect->assertRedirect(route('reservas.index'));
        $responseRedirect->assertSessionHas('success', 'Cupon creado exitosamente.');
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reserva = ReservaModel::factory()->create();

        $response = $this->getJson(route('reservas.show', $reserva->id));

        $response->assertStatus(200)
                ->assertJson([
                    'reserva' => [
                        'title' => $reserva->title,
                        "description" => $reserva->description,
                        "location" => $reserva->location,
                        "start_date" => $reserva->start_date,
                        "end_date" =>  $reserva->end_date,
                        "status" =>  $reserva->status,
                        "boost" =>  $reserva->boost
                    ],
                    'solicitudes' => [] 
                ]);

        $response = $this->get(route('reservas.show', $reserva->id));

        $response->assertStatus(200)
                ->assertViewIs('reservas.show')
                ->assertViewHas('reservas', function ($viewReservas) use ($reserva) {
                    return $viewReservas->id === $reserva->id;
                });
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reserva = ReservaModel::factory()->create();

        $response = $this->getJson(route('reservas.edit', $reserva->id));

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $reserva->id,
                    'title' => $reserva->title,
                    "description" => $reserva->description,
                    "location" => $reserva->location,
                    "start_date" => $reserva->start_date,
                    "end_date" =>  $reserva->end_date,
                    "status" =>  $reserva->status,
                    "boost" =>  $reserva->boost
                ]);

        $response = $this->get(route('reservas.edit', $reserva->id));

        $response->assertStatus(200)
                ->assertViewIs('reservas.edit')
                ->assertViewHas('reserva', $reserva);
    }

    public function testUpdateWithoutImageChanges()
    {
        $user = User::factory()->create();
        $reserva = ReservaModel::factory()->create();
        $this->actingAs($user);
    
        $updateData = [
            "title" => "Updated Title",
            "description" => "Updated Description",
            "location" => "Updated Location",
            "start_date" => now()->format('Y-m-d'),
            "end_date" => now()->addDays(5)->format('Y-m-d'),
            "status" => "Pendiente",
            "boost" => false,
        ];
    
        $response = $this->patch(route('reservas.update', $reserva->id), $updateData);
    
        $response->assertStatus(302);
        $response->assertRedirect(route('reservas.index'));
        $response->assertSessionHas('success', 'Reserva actualizada exitosamente');
        $this->assertDatabaseHas('reservas', $updateData);
    }
    
    public function testUpdateWithImageDeletion()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $reserva = ReservaModel::factory()->create();
    
        // Crea una imagen y asociarla con la reserva que queremos eliminar
        $imageToDelete = \App\Models\ReservaImage::create([
            'reserva_id' => $reserva->id,
            'image_path' => 'image_to_delete.jpg', 
        ]);
    
        Storage::disk('public')->put('images/image_to_delete.jpg', 'contenido falso');
    
        $this->actingAs($user);
    
        $updateData = [
            "title" => "Updated Title",
            "description" => "Updated Description",
            "location" => "Updated Location",
            "start_date" => now()->format('Y-m-d'),
            "end_date" => now()->addDays(5)->format('Y-m-d'),
            "status" => "inactive",
            "boost" => false,
            "delete_images" => [$imageToDelete->id], 
        ];
    
        $response = $this->patch(route('reservas.update', $reserva->id), $updateData);
    
        $response->assertStatus(302);
        $response->assertRedirect(route('reservas.index'));
        $response->assertSessionHas('success', 'Reserva actualizada exitosamente');
    
        $this->assertDatabaseMissing('reserva_images', ['id' => $imageToDelete->id]);
    
        Storage::disk('public')->assertMissing('images/' . $imageToDelete->image_path);
    }
    
    
    public function testUpdateWithNewImages()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $reserva = ReservaModel::factory()->create();
        $this->actingAs($user);

        $newImage = UploadedFile::fake()->image('new_image.jpg');

        $updateData = [
            "title" => "Updated Title",
            "description" => "Updated Description", 
            "location" => "Updated Location",
            "start_date" => now()->format('Y-m-d'),
            "end_date" => now()->addDays(5)->format('Y-m-d'),
            "status" => "Pendiente",
            "boost" => false,
            "images" => [$newImage], 
        ];

        $response = $this->patch(route('reservas.update', $reserva->id), $updateData);

        $response->assertStatus(302);
        $response->assertRedirect(route('reservas.index'));
        $response->assertSessionHas('success', 'Reserva actualizada exitosamente');

        $reserva->refresh();

        $imageName = $reserva->updated_at->timestamp . '_' . $newImage->getClientOriginalName();

        $this->assertDatabaseHas('reserva_images', [
            'reserva_id' => $reserva->id,
            'image_path' => $imageName,
        ]);

        Storage::disk('public')->assertExists('images/' . $imageName);
    }

    public function testDestroyReservaWithJsonRequest()
{
    $user = User::factory()->create();
    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    $response = $this->json('DELETE', route('reservas.destroy', $reserva->id));

    $response->assertStatus(200);
    $response->assertJson($reserva->toArray());

    $this->assertDatabaseMissing('reservas', ['id' => $reserva->id]);
}

public function testDestroyReservaWithRedirect()
{
    $user = User::factory()->create();
    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    $response = $this->delete(route('reservas.destroy', $reserva->id));

    $response->assertStatus(302);
    $response->assertRedirect(route('reservas.index'));
    $response->assertSessionHas('success', 'Reserva eliminada exitosamente.');

    $this->assertDatabaseMissing('reservas', ['id' => $reserva->id]);
}

public function testSolicitarWithIncompleteProfile()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->make([
        'dpi_photo' => null, 
    ]);
    $user->detalleUsuario()->save($detalleUsuario);
    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('reservas.solicitar', $reserva->id));

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('warning', 'Para realizar una reserva, debes completar tu perfil.');
}

public function testSolicitarWhenAlreadyRequested()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->create(['user_id' => $user->id]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    $solicitud = Solicitud::factory()->create([
        'correo' => $user->email,
        'reserva_id' => $reserva->id,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('reservas.solicitar', $reserva->id));

    $response->assertRedirect()->back();
    $response->assertSessionHas('error', 'Ya has enviado una solicitud para esta reserva. Por favor, espera la respuesta del host.');
}

public function testSolicitarSuccessfully()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->create(['user_id' => $user->id]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('reservas.solicitar', $reserva->id));

    $response->assertRedirect()->back();
    $response->assertSessionHas('success', 'Solicitud de reserva enviada con éxito.');

    $this->assertDatabaseHas('solicitudes', [
        'correo' => $user->email,
        'reserva_id' => $reserva->id,
        'estado' => 'Pendiente',
    ]);
}

public function testSolicitarWithIncompleteProfileAndJsonRequest()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->make([
    ]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    $response = $this->json('POST', route('reservas.solicitar', $reserva->id));

    $response->assertStatus(400); 
    $response->assertJson([
        'status' => 'warning',
        'message' => 'Para realizar una reserva, debes completar tu perfil.'
    ]);
}

public function testSolicitarWhenAlreadyRequestedWithJsonRequest()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->create(['user_id' => $user->id]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    Solicitud::factory()->create([
        'correo' => $user->email,
        'reserva_id' => $reserva->id,
    ]);
    $this->actingAs($user);

    $response = $this->json('POST', route('reservas.solicitar', $reserva->id));

    $response->assertStatus(400); 
    $response->assertJson([
        'status' => 'error',
        'message' => 'Ya has enviado una solicitud para esta reserva. Por favor, espera la respuesta del host.'
    ]);
}


public function testSolicitarSuccessfullyWithJsonResponse()
{
    $user = User::factory()->create();
    $detalleUsuario = DetalleUsuario::factory()->create(['user_id' => $user->id]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    $response = $this->json('POST', route('reservas.solicitar', $reserva->id));

    $response->assertStatus(200); 
    $response->assertJson([
        'status' => 'success',
        'message' => 'Solicitud de reserva enviada con éxito.'
    ]);

    $this->assertDatabaseHas('solicitudes', [
        'correo' => $user->email,
        'reserva_id' => $reserva->id,
    ]);
}

}