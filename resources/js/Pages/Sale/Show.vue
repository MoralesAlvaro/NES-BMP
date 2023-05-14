<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue'
import Button from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import FormSale from '@/Components/Sale/FormSale.vue'
import { reactive, ref } from 'vue';
import { createToaster } from "@meforma/vue-toaster";
import { useForm, usePage } from '@inertiajs/vue3';
import Empty from '@/Components/Empty.vue';
import Pagination from '@/Components/Pagination.vue';
import IsLoanding from '@/Components/IsLoanding.vue';
import ShowDetailSale from '@/Components/Sale/ShowDetailSale.vue'

const props = defineProps({
    sales: Object,
    stocks: Object,
    typeDoc: Array,
    typeProduct: Array,
    statusSale: Object,
    permissions: Array
});

const isLoading = ref(false);
const header = reactive([
    {
        name: '#',
        showInMobile: true
    },
    {
        name: "Fecha",
        showInMobile: true
    },
    {
        name: "Estado",
        showInMobile: true
    },
    {
        name: "Sub total",
        showInMobile: true
    },
    {
        name: 'Descuentos',
        showInMobile: true
    },
    {
        name: 'Total',
        showInMobile: true
    },
    {
        name: 'Acciones',
        showInMobile: true
    }
]);

const selectedSale = reactive({
    id: null,
    status_sale_id: null,
    sup_total: null,
    discount: null,
    total: null,
    detailSale: null,
});

const toaster = createToaster({ /* options */ });
const isEdit = ref(false);
const statusModalForm = ref(false);
const statusDetailSale = ref(false);
const statusModalDelete = ref(false);

const toggleFormModal = () => {
    statusModalForm.value = !statusModalForm.value;
};

const toggleDetailSale = () => {
    statusDetailSale.value = !statusDetailSale.value;
};

const toggleDeleteModal = () => {
    statusModalDelete.value = !statusModalDelete.value;
};

const selectItem = (item) => {
    selectedSale.id = item.id,
        selectedSale.status_sale_id = item.status_sale_id,
        selectedSale.sup_total = item.sup_total,
        selectedSale.discount = item.discount,
        selectedSale.total = item.total,
        selectedSale.detailSale = item.detailSale.map(item => ({ ...item, kind: 'old' }))
    isEdit.value = true,
        toggleFormModal()
}

const formDelete = useForm({
    id: null
});

const selectDeleteItem = item => {
    formDelete.id = item.id;
    toggleDeleteModal();
};

const submitDelete = () => {
    isLoading.value = true;
    formDelete.get(route('sale.destroy', formDelete.id), {
        onSuccess: () => {
            toaster.info(`Registro eliminado`);
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

let sale_list = false; let sale_store = false; let sale_update = false; let sale_destroy = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'sale_list') ? sale_list = true : sale_list = false;
    props.permissions.find(item => item.name === 'sale_store') ? sale_store = true : sale_store = false;
    props.permissions.find(item => item.name === 'sale_update') ? sale_update = true : sale_update = false;
    props.permissions.find(item => item.name === 'sale_destroy') ? sale_destroy = true : sale_destroy = false;
}
hasPermission()

const showDetail = (item) => {
    selectedSale.id = item.id,
        selectedSale.status_sale_id = item.status_sale_id,
        selectedSale.sup_total = item.sup_total,
        selectedSale.discount = item.discount,
        selectedSale.total = item.total,
        selectedSale.detailSale = item.detailSale.map(item => ({ ...item, kind: 'old' })),
        toggleDetailSale()
}

</script>
<template>
    <Head title="Ventas" />

    <AppLayout>
        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Ventas
            </h2>
        </template>

        <Modal :show="statusModalForm" maxWidth="7xl" @close="toggleFormModal">
            <FormSale :isEdit="isEdit" :sale="selectedSale" :typeProduct="typeProduct" :stocks="stocks"
                @close="toggleFormModal" />
        </Modal>

        <Modal :show="statusDetailSale" maxWidth="4xl" @close="toggleDetailSale">
            <ShowDetailSale :sale="selectedSale" @close="toggleDetailSale" />
        </Modal>

        <Modal :show="statusModalDelete" maxWidth="lg" @close="toggleDeleteModal">

            <IsLoanding :isLoading="isLoading"> </IsLoanding>
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
        <div class="py-6 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="flex md:justify-end sm:justify-start items-center mb-5">
                    <Button v-if="sale_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>

                <div v-if="sale_list"
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if="sales.data.length">
                        <Table :header="header" :items="sales.data.length">
                            <tbody class="px-5">
                                <tr v-for=" (item, index) in sales.data " class="mt-2 hover:bg-gray-50">
                                    <td @click="showDetail(item)" class="text-center p-2 lg:text-base text-xs text-gray-400">{{ index + 1 }}</td>
                                    <td @click="showDetail(item)" class="text-center p-2 lg:text-base text-xs">{{ item.created }}</td>
                                    <td @click="showDetail(item)" class="p-2 lg:text-base text-xs">{{ item.status_sale_id === true ?
                                        "Pagado" : "Pendiente" }}</td>
                                    <td @click="showDetail(item)" class="text-center p-2 lg:text-base text-xs">$ {{ item.sup_total.toFixed(2) }}</td>
                                    <td @click="showDetail(item)" class="text-center p-2 lg:text-base text-xs text-red-400">$ {{ item.discount.toFixed(2) }}</td>
                                    <td @click="showDetail(item)" class="text-center p-2 lg:text-base text-xs">$ {{ item.total.toFixed(2) }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">
                                        <div class="flex justify-center">
                                            <div class="flex flex-row space-x-4">
                                                <a v-if="sale_update" @click=" selectItem(item)"
                                                    class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                <a v-if="sale_destroy" @click=" selectDeleteItem(item)"
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
                        <Pagination :links="props.sales.links" :meta="props.sales.meta" />
                    </div>

                </div>
                <div v-else class="py-12 min-h-screen">
                    <Empty></Empty>
                </div>

            </div>
        </div>

    </AppLayout>
</template>
