<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservaModel;
use App\Models\ReservaImage;
use Illuminate\Http\Request;

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
        $reserva = ReservaModel::with('images')->findOrFail($id);
        return view('reservas.show', compact('reserva'));
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


}
