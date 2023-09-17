<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plazas') }}
        </h2>
        
    </x-slot>             
    <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="card w-full">
                    <img class="card-img-top w-48 h-auto" src="https://www.becas-santander.com/es/blog/productividad-en-el-trabajo/_jcr_content/root/container/responsivegrid/image_126604164.coreimg.jpeg/1637065958747/productividad-en-el-trabajo-becas.jpeg" alt="Card image cap">
                    <div class="card-body px-4 py-4">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">Nombre de Empresa</h2>
                        <p class="Descripción mb-4">Descripción sobre el empleo, información importante sobre la empresa y una breve descripción qué se requiere para poder aplicar a la plaza.</p>
                        <a href="#" class="Botton de Aplicar font-semibold hover:underline" >Editar Plaza</a> <!-- Aquí puedes programar el botón de aplicación -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
