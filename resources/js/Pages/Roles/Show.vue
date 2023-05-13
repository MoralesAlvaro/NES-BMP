<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/PrimaryButton.vue'
import DeleteRoles from '@/Components/Roles/DeleteRoles.vue'
import { Head } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

defineProps({
    roles: Object,
})

const header = reactive([{
    name: 'Nombre',
    showInMobile: true
},
{
    name: 'Acciones',
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

        <div class="py-12 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-semibold md:text-3xl text-xl text-dark-blue-500 leading-tight animated zoomIn">
                        Roles
                    </h2>

                    <Button @click="toggleFormModal(); isEdit = false">
                        Invitar
                    </Button>

                </div>

                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <Table :header="header" :items="roles.length">
                        <tbody class="px-5">
                            <tr v-for="item in roles" class="mt-2">
                                <td class="text-center p-2 lg:text-base text-xs">{{ item.name }}</td>
                            </tr>
                        </tbody>
                    </Table>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
