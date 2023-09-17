<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservaModel;

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
    ]);

    // Creamos una nueva instancia de JobsModel
    $reserva = new ReservaModel($request->all());

    // Aquí asignas el correo del usuario autenticado:
    $reserva->correo_creador = Auth::user()->email;

    $reserva->save();

    return redirect()->route('reservas.index')->with('success', 'Trabajo creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reserva = ReservaModel::find($id); // Asumiendo que tu modelo se llama "ReservaModel"

        if(!$reserva) {
            // Puedes manejar el caso en el que la reserva no se encuentre
            return redirect()->route('reservas.index')->with('error', 'Reserva no encontrada');
        }

        return view('reservas.show', compact('reserva'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reserva = ReservaModel::find($id);
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
        ]);

        $reserva = ReservaModel::find($id);
        $reserva->update($request->all());

        return redirect()->route('reservas.index')
                        ->with('success', 'Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = ReservaModel::find($id);
        $reserva->delete();

        return redirect()->route('reservas.index')
                        ->with('success', 'Product deleted successfully');
    }

}
