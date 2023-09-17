<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Personal Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's personal information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Avatar or profile picture -->
        <div>
            <x-input-label for="avatar" :value="__('Profile Picture')" />
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />

            <!-- If the user already has an avatar, show it -->
            @if($user->avatar)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ __('User Avatar') }}" width="100">
                </div>
            @endif
        </div>

        <!-- Number -->
        <div>
            <x-input-label for="number" :value="__('Número de Teléfono')" />
            <x-text-input id="number" name="number" type="text" class="mt-1 block w-full" :value="old('number', $user->detalleUsuario->number ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('number')" />
        </div>

        <!-- Birthday -->
        <div>
            <x-input-label for="birthday" :value="__('Fecha de Nacimiento')" />
            <x-text-input id="birthday" name="birthday" type="date" class="mt-1 block w-full" :value="old('birthday', $user->detalleUsuario->birthday ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('birthday')" />
        </div>

        <!-- Gender -->

        <div>
            <x-input-label for="gender" :value="__('Genero')" />
            <select name="gender" id="gender" class="mt-1 block w-full">
                @isset($user->detalleUsuario->gender)
                    <option value="masculino" @if(old('gender', $user->detalleUsuario->gender) == 'masculino') selected @endif>Masculino</option>
                    <option value="femenino" @if(old('gender', $user->detalleUsuario->gender) == 'femenino') selected @endif>Femenino</option>
                @else
                    <option value="masculino" selected>Masculino</option>
                    <option value="femenino">Femenino</option>
                @endisset
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>


       <!-- Country -->
        <div>
            <x-input-label for="country" :value="__('País')" />
            <select name="country" id="country" class="mt-1 block w-full">
                @isset($user->detalleUsuario->country)
                    <option value="Guatemala" @if(old('country', $user->detalleUsuario->country) == 'Guatemala') selected @endif>Guatemala</option>
                    <option value="México" @if(old('country', $user->detalleUsuario->country) == 'México') selected @endif>México</option>
                    <option value="Estados Unidos" @if(old('country', $user->detalleUsuario->country) == 'Estados Unidos') selected @endif>Estados Unidos</option>
                @else
                    <option value="Guatemala" selected>Guatemala</option>
                    <option value="México">México</option>
                    <option value="Estados Unidos">Estados Unidos</option>
                @endisset
                <!-- Puedes añadir más países si lo deseas -->
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <!-- Direction -->
        <div>
            <x-input-label for="direction" :value="__('Dirección')" />
            <x-text-input id="direction" name="direction" type="text" class="mt-1 block w-full" :value="old('direction', $user->detalleUsuario->direction ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('direction')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
