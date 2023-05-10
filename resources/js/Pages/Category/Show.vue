<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue'
import Button from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { reactive, ref } from 'vue';
import FormCategory from '@/Components/Category/FormCategory.vue'
import { createToaster } from "@meforma/vue-toaster";
import { useForm, usePage } from '@inertiajs/vue3';
import Empty from '@/Components/Empty.vue';
import IsLoanding from '@/Components/IsLoanding.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    categories: Object,
    permissions: Array
});

const header = reactive([
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

const selectedCategory = reactive({
    category_id: null,
    name: null,
    description: null,
    active: null,
});

const toaster = createToaster({ /* options */ });
const isEdit = ref(false);
const statusModalForm = ref(false);
const statusModalDelete = ref(false);
const isLoading = ref(false);

const toggleFormModal = () => {
    statusModalForm.value = !statusModalForm.value;
};
const toggleDeleteModal = () => {
    statusModalDelete.value = !statusModalDelete.value;
};
const selectItem = (item) => {
    selectedCategory.category_id = item.id,
        selectedCategory.name = item.name,
        selectedCategory.description = item.description,
        selectedCategory.active = item.active,
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
    formDelete.get(route('category.destroy', formDelete.id), {
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
            isLoading.value = true;
            toggleDeleteModal();
        }
    });
}

let category_list = false; let category_store = false; let category_update = false; let category_destroy = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'category_list') ? category_list = true : category_list = false;
    props.permissions.find(item => item.name === 'category_store') ? category_store = true : category_store = false;
    props.permissions.find(item => item.name === 'category_update') ? category_update = true : category_update = false;
    props.permissions.find(item => item.name === 'category_destroy') ? category_destroy = true : category_destroy = false;
}
hasPermission()

</script>

<template>
    <Head title="Categories" />
    <AppLayout>

        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            <FormCategory :isEdit="isEdit" :category="selectedCategory" @close="toggleFormModal" />
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
        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-semibold md:text-3xl text-xl text-dark-blue-500 leading-tight animated zoomIn">
                        Categorías
                    </h2>
                    <Button v-if="category_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>
                <div v-if=" category_list "
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if=" categories.data.length ">
                        <Table :header=" header " :items=" categories.data.length ">
                            <tbody class="px-5">
                                <tr v-for="  item   in   categories.data  " class="mt-2">
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.name }}</td>
                                    <td class="p-2 lg:text-base text-xs">{{ item.description }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.active }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">
                                        <div class="flex justify-center">
                                            <div class="flex flex-row space-x-4">
                                                <a v-if=" category_update " @click=" selectItem(item) "
                                                    class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                <a v-if=" category_destroy " @click=" selectDeleteItem(item) "
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
                        <Pagination :links=" props.categories.links " :meta=" props.categories.meta " />
                    </div>
                </div>
                <div v-else class="py-12 min-h-screen">
                    <Empty />
                </div>
            </div>
        </div>

    </AppLayout>
</template>
