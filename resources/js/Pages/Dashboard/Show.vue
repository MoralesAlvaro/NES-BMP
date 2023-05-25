<script setup>

import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Button from '@/Components/PrimaryButton.vue';

const props = defineProps({
    SaleMonth: Object,
    Top3: Object,
    SaleWeek: Object
});

</script>


<template>
    <Head title="Dashboard" />
    <AppLayout>
        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Dashboard
            </h2>
        </template>

        <div class="py-6 grid md:grid-cols-12 sm:grid-cols-1 gap-1">

            <div
                class="md:col-span-6 md:ml-7 md:mr-5 md:min-h-screen sm:h-auto flex flex-col sm:justify-start items-center pt-6 sm:pt-0">
                <div class="mt-6 px-6 py-4 bg-white shadow-lg overflow-hidden sm:rounded-lg ">
                    
                </div>
            </div>

            <div
                class="md:col-span-6 md:ml-7 md:mr-5 md:min-h-screen sm:h-auto flex flex-col sm:justify-start items-center pt-6 sm:pt-0">
                <div class="mt-6 px-6 py-4 bg-white shadow-lg overflow-hidden sm:rounded-lg">
                    
                </div>
            </div>

        </div>
    </AppLayout>
</template>