<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="grid grid-cols-12 gap-2 bg-gray-100">

        <div class="col-span-5 rounded-xl bg-contain bg-center hover:bg-contain" style="background-image: url(img/banners/noche_banner.jpg); " >

        </div>

        <div class="col-span-7 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 ">
            <div class="mt-6 px-6 py-4 bg-white shadow-xl overflow-hidden sm:rounded-lg sm:w-2/4">
                <div class="grid gap-2 place-items-center">
                    <div class="mt-2">
                        <Link href="/">
                        <ApplicationLogo class="w-20 h-20 fill-current text-gray-500 " />
                        </Link>
                    </div>
                    <div class="mt-2">
                        <p class="text-center text-gray-500"><strong class="items-center text-3xl font-extrabold">NES-BMP</strong></p>
                    </div>
                    <div class=" grid place-content-center">
                        <hr class=" bg-slate-400 m-2">
                        <p class=" text-gray-500"><strong class="items-center">Iniciar Sesión</strong></p>
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
