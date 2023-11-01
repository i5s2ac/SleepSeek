<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\SleepInController; // Importa el controlador SleepInController
use App\Models\ReservaModel;
use App\Models\Solicitud;
use App\Http\Controllers\CuponController; // Importa el controlador SleepInController
use App\Http\Controllers\DashboardController;



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




Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



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
    Route::patch('/reservas/{reserva}', [ReservaController::class, 'update'])->name('reservas.update'); 
    Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');
    Route::post('/reservas/{reserva}/solicitar', [ReservaController::class, 'solicitar'])->name('reservas.solicitar');
    Route::get('/mis-solicitudes', [ReservaController::class, 'misSolicitudes'])->name('reservas.mis-solicitudes');
    Route::post('/reservas/{solicitud}/aceptar', [ReservaController::class, 'aceptarSolicitud'])->name('reservas.aceptar');
    Route::post('/reservas/{solicitud}/rechazar', [ReservaController::class, 'rechazarSolicitud'])->name('reservas.rechazar');
    Route::post('/reservas/{solicitud}/regret', [ReservaController::class, 'regretSolicitud'])->name('reservas.regret');
    
    // Rutas para Cupones
    Route::get('/cupones', [CuponController::class, 'index'])->name('cupones.index');
    Route::get('/cupones/create', [CuponController::class, 'create'])->name('cupones.create');
    Route::post('/cupones', [CuponController::class, 'store'])->name('cupones.store');
    Route::get('/cupones/{cupon}', [CuponController::class, 'show'])->name('cupones.show');
    Route::get('/cupones/{cupon}/edit', [CuponController::class, 'edit'])->name('cupones.edit');
    Route::patch('/cupones/{cupon}', [CuponController::class, 'update'])->name('cupones.update'); 
    Route::delete('/cupones/{cupon}', [CuponController::class, 'destroy'])->name('cupones.destroy');

    Route::delete('/solicitudes/{id}', [ReservaController::class, 'deleteSolicitud'])->name('solicitudes.delete');

    Route::patch('/reservas/{reserva}/boost', [ReservaController::class, 'addBoost'])->name('reservas.addBoost');
    Route::delete('/reservas/{reserva}/unboost', [ReservaController::class, 'removeBoost'])->name('reservas.removeBoost');

    Route::delete('/solicitudes/{solicitud}/eliminar', [SleepInController::class, 'eliminarSolicitud'])->name('solicitudes.eliminar');
    Route::get('/SleepIn', [SleepInController::class, 'index'])->name('SleepIn');



});


Route::get('/plazas', function () {
    return view('plazas');
})->middleware(['auth'])->name('plazas');

Route::get('/verPerfil', function () {
    return view('verPerfil');
})->middleware(['auth'])->name('verPerfil');

Route::get('/verPlaza', function () {
    return view('verPlaza');
})->middleware(['auth'])->name('verPlaza');

require __DIR__.'/auth.php';
