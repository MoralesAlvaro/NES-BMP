<script setup>
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Label from '@/Components/InputLabel.vue';
import Empty from '@/Components/Empty.vue'
import Input from '@/Components/TextInput.vue';
import { reactive, ref } from 'vue';


const props = defineProps({
    sales: Object,
    permissions: Array
});

const header = reactive([
    {
        name: "#",
        showInMobile: true
    },
    {
        name: "Fecha",
        showInMobile: true
    },
    {
        name: "Total",
        showInMobile: true
    }
]);

let sale_log = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'sale_log') ? sale_log = true : sale_log = false;
}
hasPermission()


</script>

<template>
    <Head title="Bitácora" />
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Bitácora de Ventas
            </h2>
        </template>
        <div class="py-6 min-h-screen">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if="sales.length">
                        <Table :header="header" :items="sales.length">
                            <tbody class="px-5">
                                <tr v-for=" (item, index) in sales " class="mt-2 hover:bg-gray-50">
                                    <td class="text-center p-2 lg:text-base text-xs text-gray-400">{{ index + 1 }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">{{ item.fecha }}</td>
                                    <td class="text-center p-2 lg:text-base text-xs">${{ item.total_suma.toFixed(2) }}</td>
                                </tr>
                            </tbody>
                        </Table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
