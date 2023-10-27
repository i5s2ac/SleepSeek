<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;
use App\Models\User;


class CuponController extends Controller
{
    public function index()
    {
        $cupones = Cupon::where('user_id', auth()->id())->get();
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
    
        Cupon::create($data);
    
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

    public function destroy(Cupon $cupon)
    {
        $cupon->delete();
        return redirect()->route('cupones.index')->with('success', 'Cupon eliminado exitosamente.');
    }

}
