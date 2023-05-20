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
        name: "Producto",
        showInMobile: true
    },
    {
        name: "Tipo",
        showInMobile: true
    },
    {
        name: 'Cantidad',
        showInMobile: true
    },
    {
        name: 'Precio',
        showInMobile: true
    },
    {
        name: 'Total',
        showInMobile: true
    }
]);

let dailySale_list = false;
const hasPermission = () => {
    props.permissions.find(item => item.name === 'dailySale_list') ? dailySale_list = true : dailySale_list = false;
}
hasPermission()

const form = useForm({
    date: ''
});


const getDate = () => {
    console.log(form.date);
    form.get(route('dailySales'))
}

</script>

<template>
    <Head title="Venta-Diaria" />
    <AppLayout>
        <!-- Encabezado del componente -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Venta Diaria
            </h2>
        </template>

        <div class="py-6 min-h-screen">

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div class="bg-white rounded-md pb-4 mb-4 grid grid-cols-2 gap-4 p-4">
                    <div>
                        <Label for="orders" value="Fecha" />
                        <Input id="orders" v-model="form.date" @change="getDate()" type="date" class="mt-1 block w-full" />
                    </div>
                    <div >
                        <h2 v-if="sales.length > 0" class="font-semibold text-2xl leading-tight text-center mb-5 text-brown-800">
                            Total: ${{ sales[0].suma_total.toFixed(2) }}
                        </h2>
                        <h2 v-else class="font-semibold text-2xl leading-tight text-center mb-5 text-brown-800">
                            Total: $ 0.00
                        </h2>


                    </div>
                </div>

                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <div v-if="dailySale_list" class="">
                        <div v-if="sales.length > 0">
                            <Table :header="header" :items="sales.length">
                                <tbody class="px-5">
                                    <tr v-for=" (item, index) in sales " class="mt-2 hover:bg-gray-50">
                                        <td class="text-center p-2 lg:text-base text-xs">{{ index + 1 }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.producto }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.tipo }}</td>
                                        <td class="text-center p-2 lg:text-base text-xs">{{ item.cantidad }} ordenes
                                        </td>
                                        <td class="text-center p-2 lg:text-base text-xs">${{ item.cost.toFixed(2) }}
                                        </td>
                                        <td class="text-center p-2 lg:text-base text-xs">${{ item.total.toFixed(2) }}
                                        </td>
                                    </tr>
                                </tbody>

                            </Table>

                        </div>
                        <div v-else class="py-12 min-h-screen">
                        <Empty></Empty>
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
