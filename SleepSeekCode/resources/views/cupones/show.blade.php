<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Coupon Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200 space-y-6">

                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold">Coupon Details</h2>
                        <a href="{{ route('cupones.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-full">
                            Back
                        </a>
                    </div>

                    <div class="space-y-2">
                        <strong class="block text-gray-700 font-medium">Code:</strong>
                        <span>{{ $cupon->codigo }}</span>
                    </div>

                    <div class="space-y-2">
                        <strong class="block text-gray-700 font-medium">Discount:</strong>
                        <span>{{ $cupon->descuento }}</span>
                    </div>

                    <div class="space-y-2">
                        <strong class="block text-gray-700 font-medium">Expiration Date:</strong>
                        <span>{{ $cupon->fecha_expiracion }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
