<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="https://drive.google.com/uc?export=view&id=1d0MR1Tn5-ejsSv4ShSs7l4-el72wqF5c" alt="Logo de mi aplicación" class="h-9 w-auto">
                    </a>
                </div>

                <style>
                    .nav-link-active {
                        border-bottom: 2px solid #00BF63 !important;
                    }
                </style>

                <!-- Navigation Links -->

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" :class="request()->routeIs('dashboard') ? 'nav-link-active' : ''">
                        {{ __('SleepHome') }}
                    </x-nav-link>
                </div>

                <!-- Plazas Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <x-nav-link :href="route('reservas.index')" :active="request()->routeIs('reservas.index')" :class="request()->routeIs('reservas.index') ? 'nav-link-active' : ''">
                        {{ __('SleepPlace') }}
                    </x-nav-link>

                </div>
                <!-- SleepIn Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('SleepIn')" :active="request()->routeIs('SleepIn')" :class="request()->routeIs('SleepIn') ? 'nav-link-active' : ''">
                        {{ __('SleepIn') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('cupones.index')" :active="request()->routeIs('cupones.index')" :class="request()->routeIs('cupones.index') ? 'nav-link-active' : ''">
                        {{ __('SleepCoupons') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')" :class="request()->routeIs('posts.index') ? 'nav-link-active' : ''">
                        {{ __('SleepPosts') }}
                    </x-nav-link>
                </div>


            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                    <div class="flex items-center"> <!-- Contenedor flex agregado -->
                            @if(Auth::user()->detalleUsuario && Auth::user()->detalleUsuario->avatar)
                                @php
                                    $isExternalAvatar = preg_match('/^https?:\/\//', Auth::user()->detalleUsuario->avatar);
                                    $avatarUrl = $isExternalAvatar ? Auth::user()->detalleUsuario->avatar : asset('storage/' . Auth::user()->detalleUsuario->avatar);
                                @endphp

                                <img src="{{ $avatarUrl }}" alt="{{ __('User Avatar') }}" class="rounded-full w-8 h-8 mr-0">
                            @endif
                            
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </div> <!-- Cierre del contenedor flex -->
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('SleepHome') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>