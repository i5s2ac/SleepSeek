<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;


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
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');   
    Route::get('/download-DPI', [ProfileController::class, 'downloadDpi_photo'])->name('dpi_photo.download');
    
});

Route::resource('reservas', ReservaController::class);

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
