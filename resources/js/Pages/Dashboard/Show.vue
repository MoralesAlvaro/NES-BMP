<script setup>

import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import Button from '@/Components/PrimaryButton.vue';
import LineChart from '@/Components/charts/LineChart.vue'
import SaleWek from '@/Components/charts/SaleWeek.vue'
import { reactive, ref } from 'vue';


const props = defineProps({
    SaleMonth: Array,
    Top3: Array,
    SaleWeek: Array
});

const header = reactive([{
    name: 'Producto',
    showInMobile: true
},
{
    name: 'Cantidad',
    showInMobile: true
}
]);

</script>


<template>
    <div>

        <Head title="Dashboard" />
        <AppLayout>
            <!-- Encabezado del componente -->
            <template #header>
                <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                    Dashboard
                </h2>
            </template>

            <div class="py-6 grid md:grid-cols-12 sm:grid-cols-1 gap-1">

                <div class="md:col-span-6 md:ml-7 h-auto md:mr-5 flex flex-col sm:justify-start items-center pt-6 sm:pt-0">
                    <div
                        class="w-full h-80 bg-white shadow-lg overflow-hidden sm:rounded-lg flex flex-col items-center justify-start">
                        <span class="text-gray-500 font-bold text-center mt-2">Ventas Semanales</span>
                        <SaleWek class="w-full h-full p-2" :value="SaleWeek" />
                    </div>
                </div>

                <div class="md:col-span-6 md:ml-7 md:mr-5 flex flex-col sm:justify-start items-center pt-6 sm:pt-0">
                    <div
                        class="w-full h-80 bg-white shadow-lg overflow-hidden sm:rounded-lg flex flex-col items-center justify-start">
                        <span class="text-gray-500 font-bold text-center mt-2">Ventas Mensulaes</span>
                        <LineChart class="w-full h-full p-2" :value="SaleMonth" />
                    </div>
                </div>

            </div>
            <div class="md:ml-7 md:mr-5 flex flex-col sm:justify-start items-center pt-6 sm:pt-0">
                <div class="w-full bg-white shadow-lg overflow-hidden sm:rounded-lg">
                    <div class="flex justify-center">
                        <span class="text-gray-500 font-bold text-center mt-2">Top productos más vendidos</span>
                    </div>
                    <Table :header="header" :items="Top3.length">
                        <tbody class="px-5">
                            <tr v-for="item in Top3" class="mt-2">
                                <td class="text-center p-2 lg:text-base text-xs capitalize">{{ item.name }}</td>
                                <td class="text-center p-2 lg:text-base text-xs">{{ item.totales }}</td>
                            </tr>
                        </tbody>
                    </Table>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
