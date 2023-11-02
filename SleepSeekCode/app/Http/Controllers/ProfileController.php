<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        if ($request->wantsJson()) {
            return response()->json($user, 200); // 200 es el código HTTP para "OK"
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user(); // Definimos la variable $user
        $user->fill($request->validated());


        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Guarda o actualiza el detalle del usuario
        $detailsData = [
            'number' => $request->input('number'),
            'birthday' => $request->input('birthday'),
            'gender' => $request->input('gender'),
            'country' => $request->input('country'),
            'direction' => $request->input('direction'),
            'DPI' => $request->input('DPI'),
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $detailsData['avatar'] = $path; // Guarda la ruta en el array $detailsData
    
            // Si el usuario ya tiene un avatar en detalles_usuario, lo eliminamos
            if ($user->detalleUsuario && $user->detalleUsuario->avatar) {
                Storage::delete($user->detalleUsuario->avatar);
            }
        }

        // Si el formulario envió un archivo 'cv'
        if ($request->hasFile('dpi_photo')) {
            $cvPath = $request->file('dpi_photo')->store('dpi_photos', 'public');
            $detailsData['dpi_photo'] = $cvPath;

            // Si el usuario ya tiene un currículum en detalles_usuario, lo eliminamos
            if ($user->detalleUsuario && $user->detalleUsuario->cv) {
                Storage::delete($user->detalleUsuario->cv);
            }
        }

        // Si el usuario ya tiene detalles, los actualizamos. Si no, los creamos.
        if ($user->detalleUsuario) { 
            $user->detalleUsuario->update($detailsData);
        } else {
            $user->detalleUsuario()->create($detailsData + ['correo' => $user->email]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function downloadDpi_photo()
    {
        $user = auth()->user();

        // Accede al CV desde la relación detalleUsuario
        $DPIPath = $user->detalleUsuario->dpi_photo ?? null;

        if (!$DPIPath) {
            return redirect()->back()->with('error', 'DPI no encontrado');
        }

        // Genera el nombre del archivo con el nombre del usuario
        $friendlyUserName = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $user->name));
        $fileName = 'DPI_Photo-' . $friendlyUserName . '.pdf';

        return response()->download(storage_path('app/public/' . $DPIPath), $fileName);
    }

    

}
