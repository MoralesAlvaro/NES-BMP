<script setup>
import JetButton from '@/Components/PrimaryButton.vue';
import { ref, getCurrentInstance } from 'vue';
import Loading from 'vue3-loading-overlay';
import { createToaster } from "@meforma/vue-toaster";
import { useForm, usePage } from '@inertiajs/vue3';

const emit = defineEmits(['close']);
const props = defineProps({
    user: {
        type: Object
    },
});

const isLoading = ref(false);
const form = useForm({
    id: props.user.user_id,
});
const route = window.route;
const toaster = createToaster({ /* options */ });

const submit = () => {
  isLoading.value = true;
  route && form.get(route('delete.user', props.user.user_id), {
    onSuccess: () => {
        toaster.success(`El registro se ha actualizado correctamente`);
    },
    onError: () => {
      const errors = usePage().props.value.errors;
      for (const key in errors) {
        if (Object.hasOwnProperty.call(errors, key)) {
            toaster.warning(`Algo salio mal, por favor ponte en contacto con el encargado`);
        }
      }
    },
    onFinish: () => {
      emit('close');
      isLoading.value = false;
    }
  });
};
</script>

<template>
  <form @submit.prevent="submit" class="py-8 px-5">
    <Loading :active.sync="isLoading" ></Loading>
    <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar a este usuario?</h2>
    <div class="px-5">
      <p class="mt-5 text-justify text-gray-400">
        Al  eliminar a este usuario se borrará permanentemente del sistema, y ya no tendrá ningún acceso al sistema.
        Por favor confirmar la acción haciendo click en el botón de 'Eliminar'.
      </p>
      <div class="flex justify-end mt-5">
        <div class="w-auto flex flex-row space-x-4 justify-between">
          <JetButton
            background="bg-transparente text-gray-300 focus:ring-transparent focus:border-transparent"
            type="button"
            @click="emit('close')"
          >
            Cancelar
          </JetButton>
          <JetButton
            background="bg-red-600 focus:ring-transparent focus:border-transparent"
            type="submit"
          >
            Eliminar
          </JetButton>
        </div>
      </div>
    </div>
  </form>
</template>
