<section>
    <header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <br>

        <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Details') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile details.") }}
        </p>
        </header>

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

        <br>

        <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Legal information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's legal information.") }}
        </p>
        </header>

         <!-- DPI -->
         <div>
            <x-input-label for="DPI" :value="__('Número de DPI')" />
            <x-text-input id="DPI" name="DPI" type="number" class="mt-1 block w-full" :value="old('DPI', $user->detalleUsuario->DPI ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('DPI')" />
        </div>

        <!-- Sección de mensajes de error -->
        @if(session('error'))
            <div class="mt-2">
                <p class="font-medium text-sm text-red-600">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <!-- dpi_photo -->
        <div>
            <x-input-label for="dpi_photo" :value="__('Foto de DPI')" />
            <x-text-input id="dpi_photo" name="dpi_photo" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('dpi_photo')" />

            <br>

            <a href="{{ route('dpi_photo.download') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-download"></i> {{ __('Descargar DPI') }}
            </a>
        </div>
        
        <br>

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
