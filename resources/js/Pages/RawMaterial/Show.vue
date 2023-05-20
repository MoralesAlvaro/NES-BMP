<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Button from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue';
import { createToaster } from "@meforma/vue-toaster";
import { reactive, ref } from 'vue';
import Empty from '@/Components/Empty.vue';
import IsLoanding from '@/Components/IsLoanding.vue';
import FormRawMaterial from "@/Components/RawMaterial/FormRawMaterial.vue";


const props = defineProps({
    reawMaterials: Object,
    products: Object,
    permissions: Array
});
const isLoading = ref(false);

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

const toggleDeleteModal = () => {
    statusModalDelete.value = !statusModalDelete.value;
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

const selectedRaw = reactive({
    id: null,
    product_id: null,
    total: null,
    quantity: null,
    parts: null,
    cost: null,
    active: null,
});

const selectedRawDelete = reactive({
    id: null
});

const selectDeleteItem = (item) => {
    formDelete.id = item.id,
        toggleDeleteModal()
}

const selectItem = (item) => {
    selectedRaw.id = item.id,
        selectedRaw.product_id = item.product_id.id,
        selectedRaw.total = item.total,
        selectedRaw.quantity = item.quantity,
        selectedRaw.parts = item.parts,
        selectedRaw.cost = item.cost,
        selectedRaw.active = item.active,
        isEdit.value = true,
        toggleFormModal()
}

const formDelete = useForm({
    id: null
});

const submitDelete = () => {
    isLoading.value = true;
    formDelete.get(route('rawMaterial.destroy', formDelete.id), {
        onSuccess: () => {
            toaster.success(`Registro eliminado`);
            toggleDeleteModal();
        },
        onError: () => {
            const errors = usePage().props.errors;
            for (const key in errors) {
                if (Object.hasOwnProperty.call(errors, key)) {
                    toaster.warning(`${errors[key]}`);
                }
            }
        },
        onFinish: () => {
            toggleDeleteModal();
            isLoading.value = false;
        }
    });
}

</script>

<template>
    <Head title="MateriaPrima" />
    <AppLayout>
        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Materia prima
            </h2>
        </template>

        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            <FormRawMaterial :isEdit="isEdit" :products="props.products" :rawMaterial="selectedRaw"
                @close="toggleFormModal" />
        </Modal>

        <Modal :show="statusModalDelete" maxWidth="lg" @close="toggleDeleteModal">
            <IsLoanding :isLoading="isLoading"> </IsLoanding>
            <form @submit.prevent="submitDelete" class="py-8 px-5">
                <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar
                    esta Materia prima?</h2>
                <div class="px-5">
                    <p class="mt-5 text-justify text-gray-400">
                        Al eliminar esta Materia prima se borrará permanentemente del sistema.
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

        <div class="py-6 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="flex md:justify-end sm:justify-start items-center mb-5">
                    <Button v-if="rawMaterial_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>
                <div v-if="rawMaterial_list"
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if="reawMaterials.data.length">
                        <Table :header="header" :items="reawMaterials.data.length">
                            <tbody class="px-5">
                                <tr v-for="   item   in   reawMaterials.data  " class="mt-2">
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
                                                <a v-if="rawMaterial_update" @click=" selectItem(item)"
                                                    class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                <a v-if="rawMaterial_destroy" @click=" selectDeleteItem(item)"
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
                        <Pagination :links="props.reawMaterials.links" :meta="props.reawMaterials.meta" />
                    </div>
                </div>
                <div v-else class="py-12 min-h-screen">
                    <Empty></Empty>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
