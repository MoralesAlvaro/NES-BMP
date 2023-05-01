<script setup>
import Button from '@/Components/PrimaryButton.vue'




const emit = defineEmits(['close']);
const props = defineProps({
  role: Number
});

const submit = () => {
    alert("Hello eliminar");
}

</script>

<template>
    <div>
        <h2 class="font-semibold md:text-2xl text-lg text-dark-blue-500 leading-tight text-center">¿Deseas eliminar a este usuario?</h2>
    <div class="px-5">
      <p class="mt-5 text-justify text-gray-400">
        Al  eliminar a este usuario se borrará permanentemente del sistema, y ya no tendrá ningún acceso al sistema.
        Por favor confirmar la acción haciendo click en el botón de 'Eliminar'.
      </p>
      <div class="flex justify-end mt-5">
        <div class="w-auto flex flex-row space-x-4 justify-between">
          <Button
            background="bg-transparente text-gray-300 focus:ring-transparent focus:border-transparent"
            type="button"
            @click="emit('close')"
          >
            Cancelar
          </Button>
          <Button
            background="bg-red-600 focus:ring-transparent focus:border-transparent"
            type="submit"
          >
            Eliminar
          </Button>
        </div>
      </div>
    </div>
    </div>
</template>
