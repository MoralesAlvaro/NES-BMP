<script setup>
    import AppLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {
        Head,
        useForm,
        usePage
    } from '@inertiajs/vue3';
    import Card from '@/Components/Card.vue'
</script>

<template>

    <Head title="Categories" />
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-700 leading-tight sm:text-end md:text-start text-start">
                Equipo de Desarrollo
            </h2>
        </template>

        <div class="py-6 min-h-screen">
            <!-- Portada -->
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
                <div
                    class="bg-white w-full sm:overflow-x-hidden overflow-x-auto shadow-xl rounded-lg min-h-base border border-gray-50 animated fadeIn">
                    <img src="@/Assets/img/portada3.png" alt="NDES_logo">
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8 flex justify-center ">
                <h2 class="text-2xl font-bold text-brown-700 dark:text-white">Team Scrum</h2>
            </div>
            <!-- Cards -->
            <div class="grid md:grid-cols-3 sm:grid-cols-1 px-3">
                <!-- Scrun Master -->
                <div class="w-full md:p-2 hover:shadow-2xl hover:rounded-md hover:bg-brown-500">
                    <Card :title="'Scrum Master'"
                        :contact="{
                            nombre: 'Álvaro Flores',
                            correo: 'moralesalvaro308@gmail.com',
                            puesto: 'Scrum Master + Team lead'
                        }">
                        <img src="@/Assets/img/alvaro.jpg" alt="NDES_logo" class="md:h-32 shadow-md">
                    </Card>
                </div>

                <!-- Team scrum -->
                <div class="w-full md:p-2 hover:shadow-2xl hover:rounded-md hover:bg-brown-500">
                    <Card :title="'Developers'"
                        :contact="{
                            nombre: 'Joel Sandoval',
                            correo: 'joel2262000@gmail.com',
                            puesto: 'Desarrollador + Analista de sistema'
                        }">
                        <img src="@/Assets/img/joel.jpg" alt="NDES_logo" class="md:h-32 shadow-md">
                    </Card>
                </div>

                <div class="w-full md:p-2 hover:shadow-2xl hover:rounded-md hover:bg-brown-500">
                    <Card :title="'Developers'"
                        :contact="{
                            nombre: 'Mónica López',
                            correo: 'monica22lopez.99@gmail.com',
                            puesto: 'Desarrollador + Analista de sistema'
                        }">
                        <img src="@/Assets/img/monica.jpg" alt="NDES_logo" class="md:h-32 shadow-md">
                    </Card>
                </div>

                <div class="w-full md:p-2 hover:shadow-2xl hover:rounded-md hover:bg-brown-500">
                    <Card :title="'Developers'"
                        :contact="{
                            nombre: 'Lourdes Montano',
                            correo: 'montanolourdes325@gmail.com',
                            puesto: 'Desarrollador + Analista de sistema'
                        }">
                        <img src="@/Assets/img/lourdes.jpg" alt="NDES_logo" class="md:h-32 shadow-md">
                    </Card>
                </div>

                <div class="w-full md:p-2 hover:shadow-2xl hover:rounded-md hover:bg-brown-500">
                    <Card :title="'Developers'"
                        :contact="{
                            nombre: 'Cristian Mejia',
                            correo: 'darkmejia643@gmail.com',
                            puesto: 'Desarrollador + Analista de sistema'
                        }">
                        <img src="@/Assets/img/cristian.png" alt="NDES_logo" class="md:h-32 shadow-md">
                    </Card>
                </div>

            </div>
        </div>
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 pb-8">
            <hr />
            <div class=" p-4 text-xs">
                <h4>Este proyecto ha sido desarrollado por estudiantes de la Universidad Luterana Salvadoreña de El Salvador bajo la licencia creative commons CC-BY-NC-SA. Abril - Junio del 2023 ULS</h4>
            </div>
            <hr/>
        </div>
    </AppLayout>
</template>
