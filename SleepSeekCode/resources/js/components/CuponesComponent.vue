<template>
    <div>
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold">Mis Cupones</h2>
            <div class="mb-0">
                <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" @click="nuevoCupon">
                    <i class="fas fa-plus mr-2"></i> ¡Agregar SleepCoupon!
                </a>
            </div>
        </div>

        <div v-if="cupones.length > 0">
            <table class="min-w-full table-auto">
                <thead class="justify-between">
                    <tr class="bg-gray-100">
                        <th class="px-2 py-2">Codigo</th>
                        <th class="px-2 py-2">Descuento</th>
                        <th class="px-2 py-2">Fecha Expiración</th>
                        <th class="px-2 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-200">
                    <tr v-for="cupon in cupones" :key="cupon.id" class="bg-white border-2 border-gray-200 hover:bg-gray-100">
                        <td class="px-2 py-2 text-center">{{ cupon.codigo }}</td>
                        <td class="px-2 py-2 text-center">${{ cupon.descuento }}</td>
                        <td class="px-2 py-2 text-center">{{ cupon.fecha_expiracion }}</td>
                        <td class="px-2 py-2 flex items-center justify-center">
                            <a class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center" @click="editarCupon(cupon.id)">
                                <i class="fas fa-cog mr-2"></i> Editar
                            </a>
                            <button @click="eliminarCupon(cupon.id)" class="bg-red-500 hover:bg-red-700 text-white py-2 px-6 rounded text-decoration-none inline-flex items-center">
                                <i class="fas fa-trash mr-2"></i> Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <!-- Mensaje cuando no hay solicitudes -->
            <div class="p-6 bg-white text-center">
                <i class="fas fa-bed fa-3x mb-2 text-gray-400"></i>
                <p class="text-gray-500">No hay nada por el momento.</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            cupones: []
        };
    },
    mounted() {
        axios.get('/api/cupones')
            .then(response => {
                this.cupones = response.data;
            })
            .catch(error => {
                console.error("Hubo un error al obtener los cupones", error);
            });
    },
    methods: {
        nuevoCupon() {
            // Aquí puedes usar Vue Router o una redirección normal
            this.$router.push({ name: 'cupones.create' });
        },
        editarCupon(id) {
            // Similar a nuevoCupon, pero para editar
            this.$router.push({ name: 'cupones.edit', params: { id: id } });
        },
        eliminarCupon(id) {
            if (confirm('¿Estás seguro de que quieres eliminar este cupón?')) {
                axios.delete('/api/cupones/' + id)
                    .then(response => {
                        this.cupones = this.cupones.filter(cupon => cupon.id !== id);
                    })
                    .catch(error => {
                        console.error("Hubo un error al eliminar el cupón", error);
                    });
            }
        }
    }
}
</script>
