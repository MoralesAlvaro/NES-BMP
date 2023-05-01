<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue'
import Button from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { reactive, ref } from 'vue';
import FormStock from '@/Components/Stock/FormStock.vue';
import Empty from '@/Components/Empty.vue';
import { createToaster } from "@meforma/vue-toaster";
import Pagination from '@/Components/Pagination.vue';


const props = defineProps({
    stocks: Object,
    permissions: Array
});

const header = reactive([
    {
        name: "#",
        showInMobile: true
    },
    {
        name: "nombre",
        showInMobile: true
    },
    {
        name: "medida",
        showInMobile: true
    },
    {
        name: "costo",
        showInMobile: true
    },
    {
        name: "precio sugerido",
        showInMobile: true
    },{
        name: "ganancia",
        showInMobile: true
    },
    {
        name: 'Acciones',
        showInMobile: true
    }
]);

const selectedstock = reactive({
    stock_id: null,
    name: null,
    description: null,
    active: null,
});

const toaster = createToaster({ });
const isEdit = ref(false);
const statusModalForm = ref(false);
const statusModalDelete = ref(false);

const toggleFormModal = () => {
    statusModalForm.value = !statusModalForm.value;
};

const toggleDeleteModal = () => {
    statusModalDelete.value = !statusModalDelete.value;
};
const selectItem = (item) => {
    selectedstock.stock_id = item.id,
        selectedstock.name = item.name,
        selectedstock.description = item.description,
        selectedstock.active = item.active,
        isEdit.value = true,
        toggleFormModal()
}

const selectDeleteItem = item => {
    formDelete.id = item.id;
    toggleDeleteModal();
};

const formDelete = useForm({
    id: null
});

let stock_list = false; let stock_store = false; let stock_update = false; let stock_destroy = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'stock_list') ? stock_list = true : stock_list = false;
    props.permissions.find(item => item.name === 'stock_store') ? stock_store = true : stock_store = false;
    props.permissions.find(item => item.name === 'stock_update') ? stock_update = true : stock_update = false;
    props.permissions.find(item => item.name === 'stock_destroy') ? stock_destroy = true : stock_destroy = false;
}
hasPermission()

const submitDelete = () => {
    formDelete.get(route('stock.destroy', formDelete.id), {
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
        }
    });
}


</script>

<template>
    <Head title="stocks" />
    <AppLayout>

        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            <FormStock :isEdit="isEdit" :stock="selectedstock" @close="toggleFormModal" />
        </Modal>

        <Modal :show="statusModalDelete" maxWidth="lg" @close="toggleDeleteModal">
            <form @submit.prevent="submitDelete" class="py-8 px-5">
                <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar
                    este stocko?</h2>
                <div class="px-5">
                    <p class="mt-5 text-justify text-gray-400">
                        Al eliminar este stocko se borrará permanentemente del sistema, y ya no tendrá quedará rastro.
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
                        stock
                    </h2>
                    <Button v-if="stock_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>
                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if=" stock_list " class="">
                        <div v-if=" stocks.data.length ">
                            <Table :header=" header " :items=" stocks.data.length ">
                                <tbody class="px-5">
                                    <tr v-for=" item  in  stocks.data " class="mt-2">
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.id }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.name }}</td>
                                        <td class="p-2 lg:text-base text-xs">{{ item.measure }}</td>
                                        <td class="p-2 lg:text-base text-xs">{{ item.cost }}</td>
                                        <td class="p-2 lg:text-base text-xs">{{ item.suggested_price }}</td>
                                        <td class="p-2 lg:text-base text-xs">{{ item.gain }}</td>
                                        <!--<td class="text-center p-2 lg:text-base text-xs">{{ item.active }}</td>-->
                                        <td class="text-center p-2 lg:text-base text-xs">
                                            <div class="flex justify-center">
                                                <div class="flex flex-row space-x-4">
                                                    <a v-if=" stock_update " @click=" selectItem(item) "
                                                        class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                    <a v-if=" stock_destroy " @click=" selectDeleteItem(item) "
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
                            <Pagination
                                :links="props.stocks.links"
                                :meta="props.stocks.meta"
                            />
                        </div>
                    </div>
                    <div v-else class="py-12 min-h-screen">
                        <Empty></Empty>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
