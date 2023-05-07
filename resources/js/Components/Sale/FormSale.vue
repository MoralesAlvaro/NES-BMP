<script setup>
import Button from '@/Components/PrimaryButton.vue';
import Input from '@/Components/TextInput.vue';
import Textarea from '@/Components/TexTareaInput.vue';
import Label from '@/Components/InputLabel.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { reactive, ref, getCurrentInstance } from 'vue';
import InputError from '@/Components/InputError.vue';
import { createToaster } from "@meforma/vue-toaster";

const emit = defineEmits(['close']);
const fecha = new Date().toLocaleDateString();
const props = defineProps({
    isEdit: {
        type: Boolean
    },
    sale: {
        type: Object
    },
    statusSale: {
        type: Object
    },
    stocks: {
        type: Object
    },
    typeProduct: {
        type: Object
    },
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);

let costo = 0;

const form = useForm({
    sale_id: props.isEdit && props.sale.id || '',
    status_sale_id: props.isEdit && props.sale.status_sale_id || '',
    sub_total: props.isEdit && props.sale.sub_total || 0.00,
    discount: props.isEdit && props.sale.discount || 0.00,
    total: props.isEdit && props.sale.total || 0.00,
    totalOrders : '',
    // detail_ sale
    stock_id: '',
    type_product_id: '',
    discount: '',
    total: 0,
    orders: '',
});

// Seleccionando Stock
const selectedStock = ref({});
const handleSelectedStock = (selected) => {
    selectedStock.value = { ...selected };
    form.stock_id = selectedStock.value.id;
    // console.log(selectedStock.value.id);
    costStock();
}

// Seleccionando typeProduct
const selectedTypeProduct = ref({});
const handleSelectedTypeProduct = (selected) => {
    selectedTypeProduct.value = { ...selected };
    form.type_product_id = selectedTypeProduct.value.id;
    // console.log(selectedTypeProduct.value.id);
    costStock();
}

// Calcula el costo de las ordenes a pedir
const costStock = () => {
    selectedStock.value.mount ? costo = selectedStock.value.mount : costo = 0;
    selectedTypeProduct.value.cost ? costo = selectedTypeProduct.value.cost : costo = 0;
    selectedTypeProduct.value.cost && selectedStock.value.mount ? costo = selectedTypeProduct.value.cost + selectedStock.value.mount : 0;
    totalSale()
}

// Calcula el costo total de la venta
const totalSale = () => {
    form.total = costo * form.totalOrders;
}

const addStockArray = () => {
    
}

const submit = () => {
    isLoading.value = true;
    if (props.isEdit) {
        form.post(route('sale.update'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro actualizado correctamente.`);
            },
            onError: () => {
                toaster.warning(`Todos los campos son requeridos`);
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    } else {
        form.post(route('sale.store'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro creado correctamente.`);
            },
            onError: () => {
                toaster.warning(`Todos los campos son requeridos`);
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    }
}

const headerPreview = reactive([
    {
        name: 'Producto',
        showInMobile: true
    },
    {
        name: 'Precio',
        showInMobile: true
    },
    {
        name: 'Tipo producto',
        showInMobile: true
    },
    {
        name: 'Total Stock',
        showInMobile: true
    },
    {
        name: 'Acciones',
        showInMobile: true
    }
]);

</script>

<template>
    <form class="py-8 px-5 bg-gray-50" @submit.prevent="submit">
        <h2 class="font-semibold text-2xl text-dark-blue-500 leading-tight text-center mb-5">
            {{ isEdit ? 'Editar Venta' : 'Registrar Venta' }}
        </h2>
        <!-- Resumen de venta -->
        <div class="grid grid-cols-3 gap-4 shadow-md p-4 bg-white rounded-md">

            <div class="md:w-auto w-full md:order-last order-first mb-2 md:mb-0">
                <h6 class="text-brown-900 ">
                    Subtotal ${{ form.sub_total }}
                </h6>
            </div>

            <div class="md:w-auto w-full md:order-last order-first mb-2 md:mb-0">
                <h6 class="text-brown-900 ">
                    Descuentos ${{ form.discount }}
                </h6>
            </div>

            <div class="md:w-auto w-full md:order-last order-first mb-2 md:mb-0">
                <h6 class="text-brown-900 font-semibold text-base md:text-xl text-end">
                    Total ${{ form.total }}
                </h6>
            </div>
        </div>
        <!-- Seleccionar producto -->
        <div class="grid grid-cols-12 gap-4 shadow-md p-4 mt-4 bg-white rounded-md">

            <div class="mb-8 col-span-3">
                <Label for="rol" value="Producto" />
                <v-select v-model="form.stock_id" :options="stocks.length ? stocks : []" :reduce="(option) => option.id"
                    label="name" placeholder="Seleccionar" class="appearance-none capitalize"
                    @option:selected="handleSelectedStock">
                    <template #open-indicator="{ attributes }">
                        <svg v-bind="attributes" width="10" height="7" viewBox="0 0 10 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.95 6.3L0 1.3L1.283 0L4.95 3.706L8.617 0L9.9 1.3L4.95 6.3Z" fill="#A4AFB7" />
                        </svg>
                    </template>
                    <template #option="{ name }">
                        <span class="capitalize">{{ name }}</span>
                    </template>
                </v-select>
                <InputError class="mt-2" :message="form.errors.active" />
            </div>

            <div class="mb-8 col-span-3">
                <Label for="rol" value="Tipo producto" />
                <v-select v-model="form.type_product_id" :options="typeProduct.length ? typeProduct : []"
                    :reduce="(option) => option.id" label="name" placeholder="Seleccionar"
                    class="appearance-none capitalize" @option:selected="handleSelectedTypeProduct">
                    <template #open-indicator="{ attributes }">
                        <svg v-bind="attributes" width="10" height="7" viewBox="0 0 10 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.95 6.3L0 1.3L1.283 0L4.95 3.706L8.617 0L9.9 1.3L4.95 6.3Z" fill="#A4AFB7" />
                        </svg>
                    </template>
                    <template #option="{ name }">
                        <span class="capitalize">{{ name }}</span>
                    </template>
                </v-select>
                <InputError class="mt-2" :message="form.errors.active" />
            </div>

            <div class="col-span-2">
                <Label for="totalOrders" value="N° Ordenes" />
                <Input id="totalOrders" v-model="form.totalOrders" type="number" class="mt-1 block w-full" required
                    placeholder="0" />
                <InputError class="mt-2" :message="form.errors.totalOrders" />
            </div>

            <div class="md:w-auto w-full md:order-last order-first mb-2 md:mb-0 col-span-2 pt-6">
                <Button @click="addStockArray()" type="button">
                        Agregar
                </Button>
            </div>

            <div class="md:w-auto w-full md:order-last order-first mb-2 md:mb-0 col-span-2">
                <h6 class="text-brown-900 font-semibold text-base md:text-xl text-end">
                    Costo ${{ costo }}
                </h6>
            </div>

        </div>

        <h2 class="font-semibold pt-5 text-lg text-dark-blue-500 leading-tight text-center mb-5">
            Detalle de la orden
        </h2>
        <!-- Detalle de la orden  -->
        <div class="grid grid-cols-3 gap-4 shadow-md p-4 mt-4 bg-white rounded-md">


        </div>
    </form>
</template>
