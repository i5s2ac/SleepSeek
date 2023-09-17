<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\JobsModel;

use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobsModel::latest()->paginate(5);
    
        return view('jobs.index',compact('jobs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        "title" => "required|max:30", 
        "description" => 'required|max:255',
        "location" => "nullable",
        "start_date" => "nullable",
        "end_date" => "nullable",
        "status" => "nullable",
    ]);

    // Creamos una nueva instancia de JobsModel
    $job = new JobsModel($request->all());

    // Aquí asignas el correo del usuario autenticado:
    $job->correo_creador = Auth::user()->email;

    $job->save();

    return redirect()->route('jobs.index')->with('success', 'Trabajo creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('jobs.show',compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = JobsModel::find($id);
        return view('jobs.edit', compact('job'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "required|max:30",
            "description" => 'required|max:255',
            "location" => "nullable",
            "start_date" => "nullable",
            "end_date" => "nullable",
            "status" => "nullable",
        ]);

        $job = JobsModel::find($id);
        $job->update($request->all());

        return redirect()->route('jobs.index')
                        ->with('success', 'Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = JobsModel::find($id);
        $job->delete();

        return redirect()->route('jobs.index')
                        ->with('success', 'Product deleted successfully');
    }

}
