<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue'
import Button from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { reactive, ref } from 'vue';
import FormProduct from '@/Components/Product/FormProduct.vue'
import Empty from '@/Components/Empty.vue'
import { createToaster } from "@meforma/vue-toaster";
import Pagination from '@/Components/Pagination.vue'


const props = defineProps({
    products: Object,
    permissions: Array
});

const header = reactive([
    {
        name: "#",
        showInMobile: true
    },
    {
        name: "Categoría",
        showInMobile: true
    },
    {
        name: "Descripción",
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

const selectedProduct = reactive({
    product_id: null,
    name: null,
    description: null,
    active: null,
});

const toaster = createToaster({ /* options */ });
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
    selectedProduct.product_id = item.id,
        selectedProduct.name = item.name,
        selectedProduct.description = item.description,
        selectedProduct.active = item.active,
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

let product_list = false; let product_store = false; let product_update = false; let product_destroy = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'product_list') ? product_list = true : product_list = false;
    props.permissions.find(item => item.name === 'product_store') ? product_store = true : product_store = false;
    props.permissions.find(item => item.name === 'product_update') ? product_update = true : product_update = false;
    props.permissions.find(item => item.name === 'product_destroy') ? product_destroy = true : product_destroy = false;
}
hasPermission()

const submitDelete = () => {
    formDelete.get(route('product.destroy', formDelete.id), {
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
    <Head title="products" />
    <AppLayout>

        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            <FormProduct :isEdit="isEdit" :product="selectedProduct" @close="toggleFormModal" />
        </Modal>

        <Modal :show="statusModalDelete" maxWidth="lg" @close="toggleDeleteModal">
            <form @submit.prevent="submitDelete" class="py-8 px-5">
                <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar
                    este producto?</h2>
                <div class="px-5">
                    <p class="mt-5 text-justify text-gray-400">
                        Al eliminar este producto se borrará permanentemente del sistema, y ya no tendrá quedará rastro.
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
                        Productos
                    </h2>
                    <Button v-if="product_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>
                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if=" product_list " class="">
                        <div v-if=" products.data.length ">
                            <Table :header=" header " :items=" products.data.length ">
                                <tbody class="px-5">
                                    <tr v-for=" item  in  products.data " class="mt-2">
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.id }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.name }}</td>
                                        <td class="p-2 lg:text-base text-xs">{{ item.description }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.active }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">
                                            <div class="flex justify-center">
                                                <div class="flex flex-row space-x-4">
                                                    <a v-if=" product_update " @click=" selectItem(item) "
                                                        class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                    <a v-if=" product_destroy " @click=" selectDeleteItem(item) "
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
                                :links="props.products.links"
                                :meta="props.products.meta"
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
