<script setup>
import Button from '@/Components/PrimaryButton.vue'
import Input from '@/Components/TextInput.vue'
import Label from '@/Components/InputLabel.vue'
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import { createToaster } from "@meforma/vue-toaster";

const emit = defineEmits(['close']);
const props = defineProps({
    isEdit: {
        type: Boolean
    },
    user: {
        type: Object
    },
    success: String
});

// Setup State
const roles = computed(() => usePage().props.roles);
const isLoading = ref(false);
const toaster = createToaster({ /* options */ });

const getInfoRol = rol => {
  return rol && rol.length > 0 ? roles.value.find(item => item.name === rol[0]) : null;
}

const form = useForm({
    name: props.isEdit && props.user.name || "",
    email: props.isEdit && props.user.email || "",
    telephone: props.isEdit && props.user.telephone || "",
    role_id: props.isEdit && getInfoRol(props.user.user_role).id || null,
});

const submit = () => {
    isLoading.value = true;
    if (props.isEdit) {
        form.transform(data => ({
            ...data,
            user_id: props.user.user_id
        })).post(route('change.role'), {
            onSuccess: () => {
                toaster.info(`El registro se ha actualizado correctamente`);
                emit('close')
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
        });
    } else {
        form.post(route('invite.user'), {
            onSuccess: () => {
                emit('close');
                toaster.success(`Notificación enviada con éxito.`);
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
        });
    }
};

</script>

<template>
    <form class="py-8 px-5" @submit.prevent="submit">
        <h2 class="font-semibold text-2xl text-dark-blue-500 leading-tight text-center mb-5">
            {{ isEdit ? 'Editar usuario' : 'Invitar a usuario' }}
        </h2>
        <div class="mb-5">
            <Label for="name" value="Nombre" />
            <Input id="name" v-model="form.name" min="3" type="text" class="mt-1 block w-full" required autofocus
                />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mb-5">
            <Label for="email" value="Correo Electrónico" />
            <Input type="email" id="email" v-model="form.email" class="mt-1 block w-full" :disabled="isEdit" />
            <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mb-5">
            <Label for="telephone" value="Teléfono" />
            <Input type="text" id="telephone" maxlength="8" minlength="8" v-model="form.telephone" class="mt-1 block w-full" />
            <InputError class="mt-2" :message="form.errors.telephone" />
        </div>
        <div class="mb-8">
            <Label for="rol" value="Rol" />
            <v-select v-model="form.role_id" :options="roles.length ? roles : []" :reduce="(option) => option.id"
                label="name" placeholder="Seleccionar un rol" class="appearance-none capitalize">
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
            <InputError class="mt-2" :message="form.errors.role_id" />
        </div>

        <div class="flex justify-end mb-5">
            <div class="w-auto flex flex-row space-x-4 justify-between">
                <Button background="bg-transparente text-gray-300 focus:ring-transparent focus:border-transparent" class=" bg-brown-300 hover:bg-brown-700"
                    type="button" @click="emit('close')">
                    Cancelar
                </Button>
                <Button type="submit" class=" bg-brown-600 hover:bg-brown-900">
                    {{ isEdit ? 'Editar' : 'Invitar' }}
                </Button>
            </div>
        </div>

    </form>
</template>
