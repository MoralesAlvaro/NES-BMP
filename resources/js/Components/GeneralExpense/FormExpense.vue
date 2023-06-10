<script setup>
import Button from '@/Components/PrimaryButton.vue'
import Input from '@/Components/TextInput.vue'
import numberInput from '@/Components/NumberInput.vue'
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
    expense: {
        type: Object
    },
    success: String,
});

const toaster = createToaster({ /* options */ });
const isLoading = ref(false);
const form = useForm({
    expense_id: props.isEdit && props.expense.expense_id || '',
    name: props.isEdit && props.expense.name || '',
    total: props.isEdit && props.expense.total || '',
});

const submit = () => {
    isLoading.value = true;
    if (props.isEdit) {
        form.post(route('expense.update'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro actualizado correctamente.`);
            },
            onError: () => {
                const errors = usePage().props.errors;
                for (const key in errors) {
                    if (Object.hasOwnProperty.call(errors, key)) {
                        toaster.warning(`${errors[key]}`);
                    }
                }
            },
            onFinish: () => {
                isLoading.value = false
            }
        })
    } else {
        form.post(route('expense.store'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Registro creado correctamente.`);
            },
            onError: () => {
                const errors = usePage().props.errors;
                for (const key in errors) {
                    if (Object.hasOwnProperty.call(errors, key)) {
                        toaster.warning(`${errors[key]}`);
                    }
                }
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
            {{ isEdit ? 'Editar Gasto' : 'Registrar Gasto' }}
        </h2>
        <div class="mb-5">
            <Label for="name" value="Nombre" />
            <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus placeholder="Ingresa el nombre"/>
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mb-5">
            <Label for="total" value="Total" />
            <Input id="total" v-model="form.total" type="number" step="0.01" min="0.01" max="9999.99" pattern="[0-9]+([.,][0-9]+)?" class="mt-1 block w-full" required
                    placeholder="$ 00.00" />
            <InputError class="mt-2" :message="form.errors.total" />
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
