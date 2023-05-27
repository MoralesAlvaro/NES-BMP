<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/PrimaryButton.vue'
import DeleteRoles from '@/Components/Roles/DeleteRoles.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

defineProps({
    roles: Object,
})

const header = reactive([{
    name: 'Nombre',
    showInMobile: true
},
{
    name: 'Fecha',
    showInMobile: true
}
]);

const statusModalDelete = ref(false);
const isEdit = ref(false);
const statusModalForm = ref(false);
const selectedRole = reactive({
    role_id: null,
    name: null
})

const toggleFormModal = () => {
    statusModalForm.value = !statusModalForm.value;
};
const toggleDeleteModal = () => {
    statusModalDelete.value = !statusModalDelete.value;
};
const selectItem = (item) => {
    selectedRole.name = item.name
    isEdit.value = true
    toggleFormModal()
}
</script>

<template>
    <Head title="Roles" />
    <AppLayout>
        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Roles
            </h2>
        </template>

        <div class="py-6 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">

                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <Table :header="header" :items="roles.length">
                        <tbody class="px-5">
                            <tr v-for="item in roles" class="mt-2">
                                <td class="text-center p-2 lg:text-base text-xs">{{ item.name }}</td>
                                <td class="text-center p-2 lg:text-base text-xs">{{ new Date(item.created_at).toLocaleString('es-ES', { dateStyle: 'long', timeStyle: 'short' }) }}</td>
                            </tr>
                        </tbody>
                    </Table>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
