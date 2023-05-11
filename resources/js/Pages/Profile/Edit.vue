<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue'
import { ref } from 'vue';
import Button from '@/Components/PrimaryButton.vue'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const statusModalForm = ref(false);
const toggleFormModal = () => {
    statusModalForm.value = !statusModalForm.value;
};


</script>

<template>
    <Head title="Perfil" />

    <AuthenticatedLayout>
        <Modal :show="statusModalForm" maxWidth="lg" @close="toggleFormModal">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdatePasswordForm class="max-w-xl" />
            </div>
        </Modal>

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Perfil</h2>
        </template>

        <div class="py-12">
            <div class=" mx-auto sm:px-6 lg:px-8 space-y-6">
                <Button @click="toggleFormModal" >Cambiar contraseña</Button>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
