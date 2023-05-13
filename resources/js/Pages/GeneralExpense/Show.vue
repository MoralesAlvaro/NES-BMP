<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue'
import Button from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { reactive, ref } from 'vue';
import FormExpense from '@/Components/GeneralExpense/FormExpense.vue'
import Empty from '@/Components/Empty.vue'
import { createToaster } from "@meforma/vue-toaster";
import IsLoanding from '@/Components/IsLoanding.vue';
import Pagination from '@/Components/Pagination.vue';


const props = defineProps({
    expenses: Object,
    permissions: Array
});

const header = reactive([
    {
        name: "#",
        showInMobile: true
    },
    {
        name: "Gasto",
        showInMobile: true
    },
    {
        name: "Total",
        showInMobile: true
    },
    {
        name: 'Acciones',
        showInMobile: true
    }
]);

const selectedExpense = reactive({
    expense_id: null,
    name: null,
    total: null,
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
    selectedExpense.expense_id = item.id,
    selectedExpense.name = item.name,
    selectedExpense.total = item.total,
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

let expense_list = false; let expense_store = false; let expense_update = false; let expense_destroy = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'expense_list') ? expense_list = true : expense_list = false;
    props.permissions.find(item => item.name === 'expense_store') ? expense_store = true : expense_store = false;
    props.permissions.find(item => item.name === 'expense_update') ? expense_update = true : expense_update = false;
    props.permissions.find(item => item.name === 'expense_destroy') ? expense_destroy = true : expense_destroy = false;
}
hasPermission()

const submitDelete = () => {
    isLoading.value = true;
    formDelete.get(route('expense.destroy', formDelete.id), {
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
    <Head title="expenses" />
    <AppLayout>
        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Gastos generales
            </h2>
        </template>

        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            <FormExpense :isEdit="isEdit" :expense="selectedExpense" @close="toggleFormModal" />
        </Modal>

        <Modal :show="statusModalDelete" maxWidth="lg" @close="toggleDeleteModal">
            <IsLoanding :isLoading="isLoading"> </IsLoanding>
            <form @submit.prevent="submitDelete" class="py-8 px-5">
                <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar
                    este gasto?</h2>
                <div class="px-5">
                    <p class="mt-5 text-justify text-gray-400">
                        Al eliminar este gasto se borrará permanentemente del sistema, y ya no tendrá quedará rastro.
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
                    <Button v-if="expense_store" @click="toggleFormModal(); isEdit = false">
                        Nuevo
                    </Button>
                </div>
                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if="expense_list" class="">
                        <div v-if="expenses.data.length">
                            <Table :header="header" :items="expenses.data.length">
                                <tbody class="px-5">
                                    <tr v-for=" item  in  expenses.data " class="mt-2">
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.id }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.name }}</td>
                                        <td class="p-2 lg:text-base text-xs">{{ item.total }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">
                                            <div class="flex justify-center">
                                                <div class="flex flex-row space-x-4">
                                                    <a v-if="expense_update" @click=" selectItem(item)"
                                                        class="text-blue-500 font-medium cursor-pointer">Editar</a>
                                                    <a v-if="expense_destroy" @click=" selectDeleteItem(item)"
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
                            <Pagination :links="props.expenses.links" :meta="props.expenses.meta" />
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
