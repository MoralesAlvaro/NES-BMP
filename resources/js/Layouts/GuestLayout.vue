<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="grid md:grid-cols-12 sm:grid-cols-1 gap-2 bg-gray-100">

        <div class="md:col-span-5 rounded-xl bg-contain bg-center hover:bg-contain" id="banner_ndes">
        </div>

        <div class="md:col-span-7 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 ">
            <div class="mt-6 px-6 py-4 bg-white shadow-xl overflow-hidden sm:rounded-lg sm:w-2/4">
                <div class="grid gap-2 place-items-center">
                    <div class="mt-2 text-center">
                        <img src="img/logos/NDES_logo.png" alt="..." id="ndes_logo_lg">
                    </div>
                    <div class="mt-2">
                        <p class="text-center text-gray-500">
                            <strong class="items-center text-3xl font-extrabold">NES-BMP</strong>
                        </p>
                    </div>
                    <div class=" grid place-content-center">
                        <hr class=" bg-slate-400 m-2">
                        <p class=" text-gray-500">
                            <strong class="items-center">Iniciar Sesión</strong>
                        </p>
                        <hr class=" bg-slate-400 m-2">
                    </div>
                </div>
                <div class="px-6 py-4 bg-white ">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
