<!-- Para ver este view en el localhost utilizar /verPlaza en el browser -->

<x-app-layout>
    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="card w-full">
                        <img class="card-img-top w-64 h-auto" src="https://www.becas-santander.com/es/blog/productividad-en-el-trabajo/_jcr_content/root/container/responsivegrid/image_126604164.coreimg.jpeg/1637065958747/productividad-en-el-trabajo-becas.jpeg" alt="Card image cap">
                        <div class="card-body px-4 py-4">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">Nombre Empresa</h2>
                            <p class="Descripción mb-4">Descripción sobre el empleo, información importante sobre la empresa y qué se requiere para poder aplicar a la plaza.</p>
                            <a href="#" class="Botton de Aplicar rounded-lg bg-black text-white px-4 py-2">Aplicar</a> <!-- Aquí puedes programar el botón de aplicación -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
/* Agrega estas reglas CSS a tu archivo de hoja de estilos CSS */
.Botton.de.Aplicar {
    background-color: #e2e8f0;
    color: black;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.Botton.de.Aplicar:hover {
    background-color:#007AFF;
    color: white;
}

</style>