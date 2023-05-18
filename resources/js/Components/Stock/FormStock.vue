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
    stock: {
        type: Object
    },
    raw_materials: {
        type: Object
    },
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);

const form = useForm({
    stock_id: props.isEdit && props.stock.stock_id || '',
    raw_material_id: props.isEdit && props.stock.raw_material_id || '',
    name: props.isEdit && props.stock.name || '',
    cost: props.isEdit && props.stock.cost || '0',
    mount: props.isEdit && props.stock.mount || '0',
    gain: props.isEdit && props.stock.gain || '0',
    active: props.isEdit && props.stock.active || '',
})

const options = ([
    {
        id: 1,
        name: "Activo",
        value: true
    },
    {
        id: 0,
        name: "Inactivo",
        value: false
    }
]);

const submit = () => {
    isLoading.value = true;
    if (props.isEdit) {
        form.post(route('stock.update'), {
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
        form.post(route('stock.store'), {
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
            {{ isEdit ? 'Editar Stock' : 'Registrar Stock' }}
        </h2>

        <div class="grid grid-cols-2 gap-4">


            <div class="">
                <Label for="name" value="Nombre" />
                <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" required
                placeholder="Carne al carbón" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="">
                <Label for="raw_material_id" value="Materia prima" />
                <v-select v-model="form.raw_material_id" :options="raw_materials.data.length ? raw_materials.data : []" :reduce="(option) => option.id"
                    label="name" placeholder="Seleccionar materia prima" class="appearance-none capitalize">
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
                <InputError class="mt-2" :message="form.errors.raw_material_id" />
            </div>

            <div class="">
                <Label for="cost" value="Costo" />
                <Input id="cost" v-model="form.cost" type="number" step="0.01" class="mt-1 block w-full" required
                    placeholder="$ 00.00" />
                <InputError class="mt-2" :message="form.errors.cost" />
            </div>

            <div class="">
                <Label for="mount" value="Precio a venta" />
                <Input id="mount" v-model="form.mount" type="number" step="0.01" class="mt-1 block w-full" required
                placeholder="$ 00.00" />
                <InputError class="mt-2" :message="form.errors.mount" />
            </div>

            <div class="">
                <Label for="gain" value="Ganancia" />
                <Input id="gain" v-model="form.gain" type="number" step="0.01" class="mt-1 block w-full" required
                placeholder="$ 00.00" />
                <InputError class="mt-2" :message="form.errors.gain" />
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
