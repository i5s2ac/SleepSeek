<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Models\ReservaModel;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $reservas = ReservaModel::where('correo_creador', '!=', auth()->user()->email)->get();
    return view('dashboard', compact('reservas'));
})->middleware(['auth'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');   
    Route::get('/download-DPI', [ProfileController::class, 'downloadDpi_photo'])->name('dpi_photo.download');

    // Rutas para Reservas
    Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/create', [ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/{reserva}', [ReservaController::class, 'show'])->name('reservas.show');
    Route::get('/reservas/{reserva}/edit', [ReservaController::class, 'edit'])->name('reservas.edit');
    Route::patch('/reservas/{reserva}', [ReservaController::class, 'update'])->name('reservas.update'); // Asumiendo que tienes un método update en tu controlador.
    Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
});

Route::get('/plazas', function () {
    return view('plazas');
})->middleware(['auth'])->name('plazas');


Route::get('/chats', function () {
    return view('chats');
})->middleware(['auth'])->name('chats');

Route::get('/notificaciones', function () {
    return view('notificaciones');
})->middleware(['auth'])->name('notificaciones');

Route::get('/verPerfil', function () {
    return view('verPerfil');
})->middleware(['auth'])->name('verPerfil');

Route::get('/verPlaza', function () {
    return view('verPlaza');
})->middleware(['auth'])->name('verPlaza');

require __DIR__.'/auth.php';
