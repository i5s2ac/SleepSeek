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
                        // Enumera aquí los campos que esperas que tenga cada reserva
                        'title', 'description', 'location', 'start_date', 'end_date', 'status', 'boost'
                        // otros campos...
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
            // otros campos...
        ]);

        foreach ($reservaData['images'] as $index => $image) {
            $expectedImageName = $reserva->created_at->timestamp . '_' . $image->getClientOriginalName();
            
            // Asegúrate de que la imagen se haya almacenado en el sistema de archivos
            Storage::disk('public')->assertExists('images/' . $expectedImageName);

            // Verifica que la imagen se haya guardado correctamente en la base de datos
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

        // Prueba para respuesta JSON
        $responseJson = $this->postJson(route('reservas.store'), $reservaData);
        $responseJson->assertStatus(201);

        // Prueba para respuesta de redirección
        $responseRedirect = $this->post(route('reservas.store'), $reservaData);
        $responseRedirect->assertStatus(302);
        $responseRedirect->assertRedirect(route('reservas.index'));
        $responseRedirect->assertSessionHas('success', 'Cupon creado exitosamente.');
    }

    // ... (otras pruebas según 



    public function testShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $reserva = ReservaModel::factory()->create();

        // Simula una solicitud JSON al endpoint show
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
                    'solicitudes' => [] // Detalles de las solicitudes
                ]);

        // Simula una solicitud HTML al endpoint show
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

        // Simula una solicitud JSON al endpoint edit
        $response = $this->getJson(route('reservas.edit', $reserva->id));

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $reserva->id,
                    'title' => $reserva->title,
                    // Agrega otros campos según tu modelo
                ]);

        // Simula una solicitud HTML al endpoint edit
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
    
        // Crear una imagen y asociarla con la reserva que queremos eliminar
        $imageToDelete = \App\Models\ReservaImage::create([
            'reserva_id' => $reserva->id,
            'image_path' => 'image_to_delete.jpg', // Proporcionar explícitamente el valor de 'image_path'
        ]);
    
        // Asumir que la imagen existe en el sistema de archivos
        Storage::disk('public')->put('images/image_to_delete.jpg', 'contenido falso');
    
        $this->actingAs($user);
    
        // Datos para enviar en la solicitud de actualización, incluyendo los IDs de las imágenes a eliminar
        $updateData = [
            "title" => "Updated Title",
            "description" => "Updated Description",
            "location" => "Updated Location",
            "start_date" => now()->format('Y-m-d'),
            "end_date" => now()->addDays(5)->format('Y-m-d'),
            "status" => "inactive",
            "boost" => false,
            "delete_images" => [$imageToDelete->id], // IDs de imágenes para eliminar
        ];
    
        $response = $this->patch(route('reservas.update', $reserva->id), $updateData);
    
        // Verificar la redirección y el mensaje de sesión
        $response->assertStatus(302);
        $response->assertRedirect(route('reservas.index'));
        $response->assertSessionHas('success', 'Reserva actualizada exitosamente');
    
        // Verificar que la imagen se eliminó de la base de datos
        $this->assertDatabaseMissing('reserva_images', ['id' => $imageToDelete->id]);
    
        // Verificar que la imagen se eliminó del disco
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
            "description" => "Updated Description", // Asegúrate de que estos campos estén incluidos
            "location" => "Updated Location",
            "start_date" => now()->format('Y-m-d'),
            "end_date" => now()->addDays(5)->format('Y-m-d'),
            "status" => "Pendiente",
            "boost" => false,
            "images" => [$newImage], // Nuevas imágenes para agregar
        ];

        $response = $this->patch(route('reservas.update', $reserva->id), $updateData);

        $response->assertStatus(302);
        $response->assertRedirect(route('reservas.index'));
        $response->assertSessionHas('success', 'Reserva actualizada exitosamente');

        // Aquí deberías refrescar la instancia de la reserva para obtener la actualización más reciente
        $reserva->refresh();

        // Asegúrate de que la lógica de creación del nombre de la imagen sea consistente en la prueba y en la aplicación
        $imageName = $reserva->updated_at->timestamp . '_' . $newImage->getClientOriginalName();

        // Verifica que la nueva imagen se haya añadido correctamente a la base de datos
        $this->assertDatabaseHas('reserva_images', [
            'reserva_id' => $reserva->id,
            'image_path' => $imageName,
        ]);

        // Verifica que la nueva imagen se haya añadido al disco
        Storage::disk('public')->assertExists('images/' . $imageName);
    }

    public function testDestroyReservaWithJsonRequest()
{
    $user = User::factory()->create();
    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    // Simula una solicitud JSON
    $response = $this->json('DELETE', route('reservas.destroy', $reserva->id));

    // Verifica que la respuesta sea correcta
    $response->assertStatus(200);
    $response->assertJson($reserva->toArray());

    // Verifica que la reserva se haya eliminado de la base de datos
    $this->assertDatabaseMissing('reservas', ['id' => $reserva->id]);
}

public function testDestroyReservaWithRedirect()
{
    $user = User::factory()->create();
    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    // Realiza una solicitud HTTP regular
    $response = $this->delete(route('reservas.destroy', $reserva->id));

    // Verifica que el usuario sea redirigido al índice de reservas
    $response->assertStatus(302);
    $response->assertRedirect(route('reservas.index'));
    $response->assertSessionHas('success', 'Reserva eliminada exitosamente.');

    // Verifica que la reserva se haya eliminado de la base de datos
    $this->assertDatabaseMissing('reservas', ['id' => $reserva->id]);
}

public function testSolicitarWithIncompleteProfile()
{
    $user = User::factory()->create();
    // Asumiendo que DetalleUsuario es otro modelo relacionado con el User
    $detalleUsuario = DetalleUsuario::factory()->make([
        'dpi_photo' => null, // y otros campos nulos o no establecidos
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

// Prueba para perfil incompleto con solicitud esperando respuesta JSON
public function testSolicitarWithIncompleteProfileAndJsonRequest()
{
    $user = User::factory()->create();
    // Asegúrese de que el perfil del usuario esté incompleto
    $detalleUsuario = DetalleUsuario::factory()->make([
        // Configuración de campos incompletos
    ]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    // Hacer una solicitud que espera una respuesta JSON
    $response = $this->json('POST', route('reservas.solicitar', $reserva->id));

    $response->assertStatus(400); // Se espera que devuelva un estado HTTP 400
    $response->assertJson([
        'status' => 'warning',
        'message' => 'Para realizar una reserva, debes completar tu perfil.'
    ]);
}


// Prueba para cuando ya existe una solicitud previa con respuesta JSON
public function testSolicitarWhenAlreadyRequestedWithJsonRequest()
{
    $user = User::factory()->create();
    // Asegúrese de que el perfil del usuario esté completo
    $detalleUsuario = DetalleUsuario::factory()->create(['user_id' => $user->id]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    // Simule una solicitud existente para esta reserva
    Solicitud::factory()->create([
        'correo' => $user->email,
        'reserva_id' => $reserva->id,
    ]);
    $this->actingAs($user);

    // Hacer una solicitud que espera una respuesta JSON
    $response = $this->json('POST', route('reservas.solicitar', $reserva->id));

    $response->assertStatus(400); // Se espera que devuelva un estado HTTP 400
    $response->assertJson([
        'status' => 'error',
        'message' => 'Ya has enviado una solicitud para esta reserva. Por favor, espera la respuesta del host.'
    ]);
}


public function testSolicitarSuccessfullyWithJsonResponse()
{
    $user = User::factory()->create();
    // Asegúrese de que el perfil del usuario esté completo
    $detalleUsuario = DetalleUsuario::factory()->create(['user_id' => $user->id]);
    $user->setRelation('detalleUsuario', $detalleUsuario);

    $reserva = ReservaModel::factory()->create();
    $this->actingAs($user);

    // Hacer una solicitud que espera una respuesta JSON
    $response = $this->json('POST', route('reservas.solicitar', $reserva->id));

    $response->assertStatus(200); // Se espera que devuelva un estado HTTP 200
    $response->assertJson([
        'status' => 'success',
        'message' => 'Solicitud de reserva enviada con éxito.'
    ]);

    // Verifique que la solicitud se haya guardado en la base de datos
    $this->assertDatabaseHas('solicitudes', [
        'correo' => $user->email,
        'reserva_id' => $reserva->id,
        // Otros campos según sea necesario
    ]);
}


}