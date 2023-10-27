<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservaModel;
use App\Models\ReservaImage;
use Illuminate\Http\Request;
use App\Models\Solicitud;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Aquí filtramos las reservas para mostrar solo las creadas por el usuario autenticado.
        $reservas = ReservaModel::where('correo_creador', Auth::user()->email)->latest()->paginate(5);

        return view('reservas.index',compact('reservas'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservas.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|max:30", 
            "description" => 'required|max:255',
            "location" => "required",
            "start_date" => "required",
            "end_date" => "required",
            "status" => "required",
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $reserva = new ReservaModel($request->all());

        // Aquí asignas el correo del usuario autenticado:
        $reserva->correo_creador = Auth::user()->email;
        $reserva->save();

        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                $reservaImage = new ReservaImage();
                $reservaImage->image_path = $imageName;
                $reservaImage->reserva_id = $reserva->id;
                $reservaImage->save();
            }
        }

        return redirect()->route('reservas.index')->with('success', 'Reserva creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservas = ReservaModel::findOrFail($id);
        $solicitudes = Solicitud::where('reserva_id', $reservas->id)->get();

        return view('reservas.show', compact('reservas', 'solicitudes'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reserva = ReservaModel::findOrFail($id);
        return view('reservas.edit', compact('reserva'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "required|max:30",
            "description" => 'required|max:255',
            "location" => "required",
            "start_date" => "required",
            "end_date" => "required",
            "status" => "required",
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $reserva = ReservaModel::findOrFail($id);

        // Elimina las imágenes seleccionadas
        if ($request->has('delete_images')) {
            $imagesToDelete = $request->input('delete_images');
            ReservaImage::whereIn('id', $imagesToDelete)->delete();

            // Elimina los archivos físicos de las imágenes
            foreach ($imagesToDelete as $imageId) {
                $image = ReservaImage::findOrFail($imageId);
                $imagePath = public_path('images/' . $image->image_path);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Actualiza los campos de la reserva
        $reserva->fill($request->only([
            'title',
            'description',
            'location',
            'start_date',
            'end_date',
            'status',
        ]));

        // Procesa y agrega las nuevas imágenes solo si se proporcionan
        if ($request->hasFile('images')) {
            // Elimina todas las imágenes existentes
            $reserva->images()->delete();

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);

                $reservaImage = new ReservaImage();
                $reservaImage->image_path = $imageName;
                $reservaImage->reserva_id = $reserva->id;
                $reservaImage->save();
            }
        }

        $reserva->save();

        return redirect()->route('reservas.index')
                        ->with('success', 'Reserva actualizada exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = ReservaModel::findOrFail($id);
        $reserva->delete();

        return redirect()->route('reservas.index')
                        ->with('success', 'Reserva eliminada exitosamente');
    }

    public function solicitar(ReservaModel $reserva)
    {
        $usuario = auth()->user();
        $perfilUsuario = $usuario->detalleUsuario;

        $camposCompletados = 0;
        // Calcula cuántos campos están completados en el perfil del usuario
        if ($perfilUsuario) {
            if (!empty($perfilUsuario->dpi_photo)) $camposCompletados++;
            if (!empty($perfilUsuario->direction)) $camposCompletados++;
            if (!empty($perfilUsuario->number)) $camposCompletados++;
            if (!empty($perfilUsuario->avatar)) $camposCompletados++;
            if (!empty($perfilUsuario->birthday)) $camposCompletados++;
            if (!empty($perfilUsuario->gender)) $camposCompletados++;
            if (!empty($perfilUsuario->country)) $camposCompletados++;
            if (!empty($perfilUsuario->DPI)) $camposCompletados++;
        }

        $totalCampos = 8; // Total de campos en tu detalle de usuario

        if ($camposCompletados < $totalCampos) {
            // El perfil no está completo, redirige al usuario a la página de edición de perfil
            return redirect()->route('profile.edit')->with('warning', 'Para realizar una reserva, debes completar tu perfil.');
        }

        $solicitudExistente = $reserva->solicitudes()->where('correo', $usuario->email)->exists();

        if ($solicitudExistente) {
            return redirect()->back()->with('error', 'Ya has enviado una solicitud para esta reserva. Por favor, espera la respuesta del host.');
        }

        if (!$solicitudExistente) {
            $solicitud = new Solicitud();
            $solicitud->correo = $usuario->email;
            $solicitud->reserva_id = $reserva->id;
            $solicitud->avatar = $perfilUsuario->avatar;
            $solicitud->number = $perfilUsuario->number;
            $solicitud->birthday = $perfilUsuario->birthday;
            $solicitud->gender = $perfilUsuario->gender;
            $solicitud->country = $perfilUsuario->country;
            $solicitud->direction = $perfilUsuario->direction;
            $solicitud->dpi_photo = $perfilUsuario->dpi_photo;
            $solicitud->DPI = $perfilUsuario->DPI;
            $solicitud->estado = 'pendiente'; // Puedes configurar el estado como "pendiente" por defecto
            $solicitud->save();

            return redirect()->back()->with('success', 'Solicitud de reserva enviada con éxito.');
        }

        return redirect()->back()->with('error', 'Ya has enviado una solicitud para esta reserva.');
    }
    
    public function aceptarSolicitud(Solicitud $solicitud)
    {
        $solicitud->update(['estado' => 'aceptada']);
        
        // Obtener la reserva correspondiente a esta solicitud
        $reserva = $solicitud->reserva;
        
        // Actualizar el estado de la reserva a "ocupado"
        $reserva->update(['status' => 'ocupado']);

        // Rechazar automáticamente el resto de las solicitudes asociadas a la misma reserva
        $reserva->solicitudes()->where('id', '<>', $solicitud->id)->update(['estado' => 'rechazada']);
    
        return redirect()->back()->with('success', 'Solicitud aceptada exitosamente');
    }

    public function rechazarSolicitud(Solicitud $solicitud)
    {
        $solicitud->update(['estado' => 'rechazada']);

        // Obtener la reserva correspondiente a esta solicitud
        $reserva = $solicitud->reserva;
        
        // Actualizar el estado de la reserva a "ocupada"
        $reserva->update(['status' => 'disponible']);

        return redirect()->back()->with('success', 'Solicitud rechazada exitosamente');
    }

    public function regretSolicitud(Request $request, $id)
    {
        $solicitudActual = Solicitud::find($id);
    
        if ($solicitudActual) {
            // Cambiar el estado de la solicitud actual a "Pendiente"
            $solicitudActual->estado = 'pendiente';
            $solicitudActual->save();
    
            // Cambiar el estado de todas las otras solicitudes relacionadas a "Pendiente"
            $reservaId = $solicitudActual->reserva_id;
            Solicitud::where('reserva_id', $reservaId)
                ->where('estado', 'rechazada')
                ->update(['estado' => 'pendiente']);
    
            // Obtener la reserva correspondiente a esta solicitud
            $reserva = $solicitudActual->reserva;
    
            // Actualizar el estado de la reserva a "disponible"
            $reserva->update(['status' => 'disponible']);
    
            // Redirigir de nuevo a la página de gestión de solicitudes
            return redirect()->route('reservas.show', $reservaId)->with('success', 'Arrepentimiento exitoso');
        }
    }
    
    public function deleteSolicitud($id)
    {
        $solicitud = Solicitud::findOrFail($id);

        if ($solicitud) {
            $solicitud->delete();
            return back()->with('success', 'Solicitud eliminada correctamente.');
        } else {
            return back()->with('error', 'Solicitud no encontrada.');
        }
    }

    public function addBoost(ReservaModel $reserva)
    {
        $reserva->boost = true;
        $reserva->save();
    
        return redirect()->route('reservas.index')->with('success', 'SleepPlace Boosted Successfully!');
    }
    
    public function removeBoost(ReservaModel $reserva)
    {
        $reserva->boost = false;
        $reserva->save();
    
        return redirect()->route('reservas.index')->with('success', 'SleepBoost Removed Successfully!');
    }

   
    

}
