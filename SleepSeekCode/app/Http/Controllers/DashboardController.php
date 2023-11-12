<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservas;
use App\Models\User;
use App\Models\ReservaModel;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $reservas = ReservaModel::where('correo_creador', '!=', auth()->user()->email)->get();

        if ($request->wantsJson()) {
            return response()->json($reservas, 200); // 200 es el código HTTP para "OK"
        }

        return view('dashboard', compact('reservas'));
    }
}
