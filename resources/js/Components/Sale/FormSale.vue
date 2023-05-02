<script setup>
import Button from '@/Components/PrimaryButton.vue'
import Input from '@/Components/TextInput.vue'
import Textarea from '@/Components/TexTareaInput.vue'
import Label from '@/Components/InputLabel.vue'
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, getCurrentInstance } from 'vue';
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
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);

const form = useForm({
    status_sale_id: props.isEdit && props.sale.status_sale_id || '',
    sub_total: props.isEdit && props.sale.sub_total || 0.00,
    discount: props.isEdit && props.sale.discount || 0.00,
    total: props.isEdit && props.sale.total || 0.00,
    product: '',
});

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

</script>

<template>
    <form class="py-8 px-5 bg-gray-50" @submit.prevent="submit">
        <h2 class="font-semibold text-2xl text-dark-blue-500 leading-tight text-center mb-5">
            {{ isEdit ? 'Editar Venta' : 'Registrar Venta' }}
        </h2>
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

        <div class="grid grid-cols-2 gap-4 shadow-md p-4 mt-4 bg-white rounded-md">

            <div class="mb-8">
                <Label for="rol" value="Producto" />
                <v-select v-model="form.product" :options="stocks.length ? stocks : []" :reduce="(option) => option.id"
                    label="name" placeholder="Seleccionar un estado" class="appearance-none capitalize">
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

            <div class="md:w-auto w-full md:order-last order-first mb-2 md:mb-0">
                <h6 class="text-brown-900 font-semibold text-base md:text-xl text-end">
                    Precio ${{ form.total }}
                </h6>
            </div>

        </div>
    </form>
</template>
