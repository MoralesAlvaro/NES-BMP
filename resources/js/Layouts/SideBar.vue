<script setup>
    // Importando el logo del sistema.
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    // Importando el componente "Link" de Intertia.
    import { Link } from '@inertiajs/vue3';
    // Importando la información del menú lateral.
    import { sidebarItems } from '@/sidebar_item';
    // Importando los componentes para montar e iniciar Flowbite.
    import { onMounted } from 'vue';
    import { initFlowbite } from 'flowbite';
    import { Inertia } from '@inertiajs/inertia';

    // Instanciando la información del menú lateral en una constante.
    const menu = sidebarItems;

    // Inicializando los componentes de Flowbite.
    onMounted(() => {
        initFlowbite();
    });

    const signOut = () => {
        Inertia.post(route('logout'));
        window.location.reload()
    }
</script>
<template>
    <!-- Apartado superior del componente del menú lateral -->
    <div class="md:fixed sm:relative top-0 left-0 z-50 md:w-50">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <!-- Logo del sistema -->
            <div>
                <Link :href="route('dashboard')">
                <ApplicationLogo />
                </Link>
            </div>
            <!-- Inicio del botón de menú lateral en vista móvil -->
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                        type="button"
                        class="inline-flex items-center p-2 text-sm text-white rounded-lg md:hidden hover:bg-gray-100  dark:text-gray-400 dark:hover:bg-gray-700 ">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Fin del botón -->
        </div>
    </div>

    <!-- Inicio del menú lateral -->
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 md:w-50 h-screen pt-20 transition-transform -translate-x-full bg-brown-600 border-r border-gray-200 sm:translate-x-0 shadow-lg"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-brown-600">

            <!-- Listado de opciones del menú lateral -->
            <ul class="space-y-2 font-medium">
                <!-- Opciones del perfil de usuario -->
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-brown-500 bg-white hover:text-gray-900 transition duration-75 rounded-lg group"
                        aria-controls="ndes_sidebar_dropdown" data-collapse-toggle="ndes_sidebar_dropdown">
                        <svg aria-hidden="true"
                            class="flex-shtink-0 w-6 h-6 text-brown-800 transition duration-75 hover:text-brown-700"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <!-- Imprimiendo el nombre del usuario -->
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>
                            {{ $page.props.auth.user.name }}
                        </span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="ndes_sidebar_dropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a :href="route('profile.edit')" class="flex items-center p-2 text-white rounded-lg hover:bg-brown-100 hover:text-brown-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6 mr-4 ml-2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="ml-3">Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a @click="signOut" method="post" as="button"
                                class="flex items-center justify-around w-full p-2 text-white rounded-lg hover:bg-brown-100 hover:text-brown-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            <span class="ml-3">Cerrar sesión</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <hr>
                </li>
                <!-- Opciones del menú lateral importando la información de "@/sidebar_item". -->
                <ul v-for="(item, index) in menu" :key="index">
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-white rounded-lg hover:bg-gray-100 hover:text-brown-700 transition duration-500"
                            :aria-controls="item.aria" :data-collapse-toggle="item.aria">
                            <i :class="item.icon"></i>
                            <span class="ml-3">
                                {{item.name}}
                                <i class="fas fa-sort-down"></i>
                            </span>
                        </button>
                        <ul class="hidden py-2 space-y-2 pl-4" :id="item.aria">
                            <li v-for="child in item.children">
                                <a :href="route(child.item_url)"
                                    class="flex items-center w-full p-2 text-white rounded-lg hover:bg-gray-100 hover:text-brown-700 transition duration-500">
                                    <i :class="child.icon"></i>
                                    <span class="ml-3">{{child.name}}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- Opción de ayuda del sistema -->
                <li>
                    <a href="https://drive.google.com/drive/folders/1dXgWxXtu_fnqkRpZWZtffDN8gHsaX3Aq?usp=sharing" target="_blank"
                        class="flex items-center p-2 text-white rounded-lg hover:bg-gray-100 hover:text-brown-700">
                        <i class="fas fa-question-circle"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Centro de ayuda</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <!-- Fin del menú lateral -->
</template>
