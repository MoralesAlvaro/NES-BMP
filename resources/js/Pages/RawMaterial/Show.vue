<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Button from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { createToaster } from "@meforma/vue-toaster";
import { reactive, ref } from 'vue';
import Empty from '@/Components/Empty.vue';

const props = defineProps({
    reawMaterials: Object,
    permissions: Array
});

const toaster = createToaster({ /* options */ });
const isEdit = ref(false);
const statusModalForm = ref(false);
const statusModalDelete = ref(false);

let rawMaterial_list = false; let rawMaterial_store = false; let rawMaterial_update = false; let rawMaterial_destroy = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'rawMaterial_list') ? rawMaterial_list = true : rawMaterial_list = false;
    props.permissions.find(item => item.name === 'rawMaterial_store') ? rawMaterial_store = true : rawMaterial_store = false;
    props.permissions.find(item => item.name === 'rawMaterial_update') ? rawMaterial_update = true : rawMaterial_update = false;
    props.permissions.find(item => item.name === 'rawMaterial_destroy') ? rawMaterial_destroy = true : rawMaterial_destroy = false;
}
hasPermission()

const toggleFormModal = () => {
    statusModalForm.value = !statusModalForm.value;
};

const header = reactive([
    {
        name: "#",
        showInMobile: true
    },
    {
        name: "Producto",
        showInMobile: true
    },
    {
        name: "Total",
        showInMobile: true
    },
    {
        name: "Cantidad",
        showInMobile: true
    },
    {
        name: "Partes",
        showInMobile: true
    },
    {
        name: "Costo",
        showInMobile: true
    },
    {
        name: "Estado",
        showInMobile: true
    },
    {
        name: 'Acciones',
        showInMobile: true
    }
]);

</script>

<template>
    <Head title="MateriaPrima" />
    <AppLayout>

        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            Crear Materia Prima
        </Modal>

        <Modal :show="statusModalDelete" maxWidth="lg" @close="toggleDeleteModal">
            <form @submit.prevent="submitDelete" class="py-8 px-5">
                <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar
                    esta categoría?</h2>
                <div class="px-5">
                    <p class="mt-5 text-justify text-gray-400">
                        Al eliminar esta categoría se borrará permanentemente del sistema, y ya no tendrá quedaraá rastro.
                        Por favor confirmar la acción haciendo click en el botón de 'Eliminar'.
                    </p>
                    <div class="flex justify-end mt-5">
                        <div class="w-auto flex flex-row space-x-4 justify-between">
                            <Button
                                background="bg-transparente text-gray-300 focus:ring-transparent focus:border-transparent"
                                class=" bg-brown-300 hover:bg-brown-700" type="button" @click="toggleDeleteModal">
                                Cancelar
                            </Button>
                            <Button type="submit" class=" bg-red-500 hover:bg-red-600">
                                {{ 'Eliminar' }}
                            </Button>
                        </div>
                    </div>

                </div>
            </form>
        </Modal>

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-semibold md:text-3xl text-xl text-dark-blue-500 leading-tight animated zoomIn">
                        Categorías
                    </h2>
                    <Button v-if="rawMaterial_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>
                <div v-if=" rawMaterial_list "
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if=" reawMaterials.data.length ">
                        <Table :header=" header " :items=" reawMaterials.data.length ">
                            <tbody class="px-5">
                                <tr v-for="  item  in  reawMaterials.data " class="mt-2">
                                    <td class="text-center p-2 lg:text-base text-xs text-gray-400">{{ item.id }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.product_id.name }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.total }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.quantity }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.parts }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.cost }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.active }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">
                                        <div class="flex justify-center">
                                            <div class="flex flex-row space-x-4">
                                                <a v-if=" rawMaterial_update " @click=" selectItem(item) "
                                                    class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                <a v-if=" rawMaterial_destroy " @click=" selectDeleteItem(item) "
                                                    class="text-blue-500 font-medium cursor-pointer">Eliminar</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </Table>
                    </div>
                    <div v-else class="py-12 min-h-screen">
                        <Empty></Empty>
                    </div>
                    <div class="p-6">
                        <Pagination :links=" props.reawMaterials.links " :meta=" props.reawMaterials.meta " />
                    </div>
                </div>
                <div v-else class="py-12 min-h-screen">
                    <Empty></Empty>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
