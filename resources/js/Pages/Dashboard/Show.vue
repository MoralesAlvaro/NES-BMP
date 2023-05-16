<script setup>

import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

</script>


<template>

    <AppLayout>

        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Dashboard
            </h2>
        </template>

    </AppLayout>
</template>

