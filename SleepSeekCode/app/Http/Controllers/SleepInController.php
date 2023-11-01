<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\User;


class SleepInController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtén el usuario actual
        $solicitudes = Solicitud::where('correo', $user->email)->get(); // Obtén las solicitudes relacionadas con el usuario

        return view('SleepIn', compact('solicitudes'));
    }

    public function eliminarSolicitud($id)
    {
        $solicitud = Solicitud::findOrFail($id);
    
        $solicitud->delete();
    
        return back()->with('success', 'Solicitud cancelada exitosamente.');
    }
    
    
}
