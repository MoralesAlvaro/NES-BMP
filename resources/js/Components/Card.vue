<script setup>
    const props = defineProps({
        title: {
            type: String
        },
        contact: {
            type: String
        }
    });
</script>

<template>
    <div class="w-full">

        <div
            class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex ">
            <div class="pl-2 pt-2 pb-2 ">
                <main>
                    <slot />
                </main>
            </div>
            <div class="m-3 ">
                <h5 class="text-2xl font-semibold text-brown-900 dark:text-white">
                    {{ props . title }}
                </h5>
                <hr>
                <p class="font-normal text-gray-500 dark:text-gray-400 mt-2">Nombre: {{ props.contact.nombre }}</p>
                <p class="font-normal text-gray-500 dark:text-gray-400">Puesto: {{ props.contact.puesto }}</p>
                <p class="font-normal text-gray-500 dark:text-gray-400">Correo: <a href="mailto: {{ props.contact.correo }}" class=" text-brown-700 hover:text-blue-800">{{ props.contact.correo }}</a></p>
            </div>
        </div>

    </div>
</template>
