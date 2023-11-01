<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;
use App\Models\User;


class CuponController extends Controller
{
    public function index(Request $request)
    {
        $cupones = Cupon::where('user_id', auth()->id())->get();

        if ($request->wantsJson()) {
            return response()->json($cupones);
        }

        return view('cupones.index', compact('cupones'));

    }

    public function create()
    {
        return view('cupones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:cupones',
            'descuento' => 'required|numeric',
            'fecha_expiracion' => 'nullable|date'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        $cupon = Cupon::create($data);

        if ($request->wantsJson()) {
            return response()->json($cupon, 200); 
        }

        return redirect()->route('cupones.index')->with('success', 'Cupon creado exitosamente.');
    }

    

    public function show(Cupon $cupon)
    {
        if($cupon->user_id !== auth()->id()){
            abort(403, 'No tienes permiso para ver este cupón.');
        }
        return view('cupones.show', compact('cupon'));
    }
    
    public function edit(Cupon $cupon)
    {
        if($cupon->user_id !== auth()->id()){
            abort(403, 'No tienes permiso para editar este cupón.');
        }
        return view('cupones.edit', compact('cupon'));
    }
    

    public function update(Request $request, Cupon $cupon)
    {
        $request->validate([
            'codigo' => 'required|unique:cupones,codigo,' . $cupon->id,
            'descuento' => 'required|numeric',
            'fecha_expiracion' => 'nullable|date'
        ]);

        $cupon->update($request->all());
        return redirect()->route('cupones.index')->with('success', 'Cupon actualizado exitosamente.');
    }

    public function destroy(Request $request, Cupon $cupon)
    {
        $deletedCupon = $cupon;  // Guarda el cupón antes de eliminarlo
        $cupon->delete();

        if ($request->wantsJson()) {
            return response()->json($deletedCupon, 200); // 200 es el código HTTP para "OK"
        }

        return redirect()->route('cupones.index')->with('success', 'Cupon eliminado exitosamente.');
    }

}
