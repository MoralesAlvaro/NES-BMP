<script setup>
import Button from '@/Components/PrimaryButton.vue'
import Input from '@/Components/TextInput.vue'
import Label from '@/Components/InputLabel.vue'
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, getCurrentInstance } from 'vue';
import InputError from '@/Components/InputError.vue';
import { createToaster } from "@meforma/vue-toaster";

const emit = defineEmits(['close']);
const props = defineProps({
    isEdit: {
        type: Boolean
    },
    rawMaterial: {
        type: Object
    },
    products: {
        type: Object
    },
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);

const form = useForm({
    rawMaterial_id: props.isEdit && props.rawMaterial.id || '',
    product_id: props.isEdit && props.rawMaterial.product_id || '',
    total: props.isEdit && props.rawMaterial.total || '',
    quantity: props.isEdit && props.rawMaterial.quantity || '',
    parts: props.isEdit && props.rawMaterial.parts || '',
    cost: props.isEdit && props.rawMaterial.cost || '',
    active: props.isEdit && props.rawMaterial.active || '',
})

const options = ([
    {
        id: 1,
        name: "Activo",
        value: true
    },
    {
        id: 2,
        name: "Inactivo",
        value: false
    }
]);

const submit = () => {
    isLoading.value = true;
    if (props.isEdit) {
        form.post(route('rawMaterial.update'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro actualizado correctamente.`);
            },
            onError: () => {
                toaster.warning(`El nombre del producto debe ser único`);
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    } else {
        form.post(route('rawMaterial.store'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro creado correctamente.`);
            },
            onError: () => {
                toaster.warning(`El nombre del producto debe ser único`);
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    }
}

</script>

<template>
    <form class="py-8 px-5" @submit.prevent="submit">
        <h2 class="font-semibold text-2xl text-dark-blue-500 leading-tight text-center mb-5">
            {{ isEdit ? 'Editar Materia Prima' : 'Registrar Materia Prima' }}
        </h2>

        <div class="grid grid-cols-2 gap-4">

            <div class="">
                <Label for="product_id" value="Producto" />
                <v-select v-model="form.product_id" :options="products.length ? products : []" :reduce="(products) => products.id"
                    label="name" placeholder="Seleccionar un producto" class="appearance-none capitalize">
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
                <InputError class="mt-2" :message="form.errors.product_id" />
            </div>

            <div class="">
                <Label for="total" value="Total" />
                <Input id="total" v-model="form.total" type="number" class="mt-1 block w-full" required
                    placeholder="$ 00.00" />
                <InputError class="mt-2" :message="form.errors.total" />
            </div>

            <div class="">
                <Label for="quantity" value="Cantidad" />
                <Input id="quantity" v-model="form.quantity" type="text" class="mt-1 block w-full" required
                    placeholder="1 LB Lomo" />
                <InputError class="mt-2" :message="form.errors.quantity" />
            </div>

            <div class="">
                <Label for="parts" value="Partes" />
                <Input id="parts" v-model="form.parts" type="number" class="mt-1 block w-full" required placeholder="0" />
                <InputError class="mt-2" :message="form.errors.parts" />
            </div>

            <div class="">
                <Label for="cost" value="Costo" />
                <Input id="cost" v-model="form.cost" type="number" class="mt-1 block w-full" required
                    placeholder="$ 00.00" />
                <InputError class="mt-2" :message="form.errors.cost" />
            </div>

            <div class="">
                <Label for="active" value="Estado" />
                <v-select v-model="form.active" :options="options.length ? options : []" :reduce="(option) => option.id"
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

        </div>

        <div class="grid grid-cols-2 gap-4 pt-6">
            <div class="w-auto flex flex-row space-x-4 justify-center">
                <Button background="bg-transparente text-gray-300 focus:ring-transparent focus:border-transparent"
                    class=" bg-brown-300 hover:bg-brown-700" type="button" @click="emit('close')">
                    Cancelar
                </Button>
            </div>

            <div class="w-auto flex flex-row space-x-4 justify-center">
                <Button type="submit" class=" bg-brown-600 hover:bg-brown-900">
                    {{ isEdit ? 'Editar' : 'Agregar' }}
                </Button>
            </div>
        </div>

    </form>
</template>
