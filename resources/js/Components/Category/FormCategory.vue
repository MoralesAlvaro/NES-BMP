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
    category: {
        type: Object
    },
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);
const form = useForm({
    name: props.isEdit && props.category.name || '',
    description: props.isEdit && props.category.description || '',
    active: props.isEdit && props.category.active || null,
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
        form.post(route('category.update'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro actualizado correctamente.`);
            },
            onError: () => {
                toaster.warning(`Algo salio mal, por favor ponte en contacto con el encargado`);
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    } else {
        form.post(route('category.store'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro creado correctamente.`);
            },
            onError: () => {
                toaster.warning(`Algo salio mal, por favor ponte en contacto con el encargado`);
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
            {{ isEdit ? 'Editar categoría' : 'Registrar categoria' }}
        </h2>
        <div class="mb-5">
            <Label for="name" value="Nombre" />
            <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <Label for="description" value="Descripción" />
            <Input id="description" v-model="form.description" type="text" class="mt-1 block w-full" required />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>
        <div class="mb-8">
            <Label for="rol" value="Estado" />
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

        <div class="flex justify-end mb-5">
            <div class="w-auto flex flex-row space-x-4 justify-between">
                <Button background="bg-transparente text-gray-300 focus:ring-transparent focus:border-transparent"
                    class=" bg-brown-300 hover:bg-brown-700" type="button" @click="emit('close')">
                    Cancelar
                </Button>
                <Button type="submit" class=" bg-brown-600 hover:bg-brown-900">
                    {{ isEdit ? 'Editar' : 'Agregar' }}
                </Button>
            </div>
        </div>

    </form>
</template>
