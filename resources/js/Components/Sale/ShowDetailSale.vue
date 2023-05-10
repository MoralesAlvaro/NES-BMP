<script setup>
import Button from '@/Components/PrimaryButton.vue';
import Table from '@/Components/Table.vue'
import Label from '@/Components/InputLabel.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { reactive, ref, getCurrentInstance } from 'vue';
import InputError from '@/Components/InputError.vue';
import { createToaster } from "@meforma/vue-toaster";

const emit = defineEmits(['close']);
const props = defineProps({
    sale: {
        type: Object
    }
});

const headerPreview = reactive([
    {
        name: '#',
        showInMobile: true
    },
    {
        name: 'Producto',
        showInMobile: true
    },
    {
        name: 'Precio',
        showInMobile: true
    },
    {
        name: 'Descuento',
        showInMobile: true
    },
    {
        name: 'Tipo producto',
        showInMobile: true
    },
    {
        name: 'Total ordenes',
        showInMobile: true
    },
]);

</script>

<template>
    <div class="py-8 px-5 bg-gray-50">
        <h2 class="font-semibold text-2xl text-dark-blue-500 leading-tight text-center mb-5">
            Detalle de Venta
        </h2>
        <div class="grid grid-cols-3 gap-4 shadow-md p-4 bg-white rounded-md">

            <div class="md:w-auto w-full md:order-last mb-2 md:mb-0">
                <h6 class="text-brown-900">
                    Subtotal ${{ props.sale.sup_total.toFixed(2) }}
                </h6>
            </div>

            <div class="md:w-auto w-full md:order-last mb-2 md:mb-0">
                <h6 class="text-brown-900 ">
                    Descuentos ${{ props.sale.discount.toFixed(2) }}
                </h6>
            </div>

            <div class="md:w-auto w-full md:order-last mb-2 md:mb-0">
                <h6 class="text-brown-900 font-bold">
                    Total ${{ props.sale.total.toFixed(2) }}
                </h6>
            </div>

        </div>
        <div class="grid shadow-md p-4 mt-4 bg-white rounded-md overflow-auto">
            <div v-if="headerPreview.length">
                <Table :header="headerPreview" :items="headerPreview.length" class=" h-80">
                    <tbody class="px-5">
                        <tr v-for=" (item, index) in props.sale.detailSale " class="mt-2">
                            <td class="text-center p-2 lg:text-base text-xs text-gray-400">{{ index + 1 }}</td>
                            <td class="text-center p-2 lg:text-base text-xs">{{ item.stock_name.name }}</td>
                            <td class="text-center p-2 lg:text-base text-xs">${{ item.stock_name.mount.toFixed(2) }}</td>
                            <td class="text-center p-2 lg:text-base text-xs">${{ item.discount.toFixed(2) }}</td>
                            <td class="text-center p-2 lg:text-base text-xs">{{ item.typeProduct.name }}</td>
                            <td class="text-center p-2 lg:text-base text-xs">{{ item.orders }}</td>
                        </tr>
                    </tbody>
                </Table>
            </div>
        </div>

    </div>
</template>
