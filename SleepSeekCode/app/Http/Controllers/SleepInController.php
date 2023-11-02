<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\User;


class SleepInController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user(); // Obtén el usuario actual
        $solicitudes = Solicitud::where('correo', $user->email)->get(); // Obtén las solicitudes relacionadas con el usuario

        if ($request->wantsJson()) {
            return response()->json($solicitudes, 200); // 200 es el código HTTP para "OK"
        }
        
        return view('SleepIn', compact('solicitudes'));
    }

    public function eliminarSolicitud(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
    
        $solicitud->delete();

        if ($request->wantsJson()) {
            return response()->json($solicitud, 200); // 200 es el código HTTP para "OK"
        }
        
        return back()->with('success', 'Solicitud cancelada exitosamente.');
        }
    
    
}
