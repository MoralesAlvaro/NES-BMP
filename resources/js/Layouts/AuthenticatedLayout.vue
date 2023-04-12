<script setup>
    import { ref } from 'vue';
    import SideBar from '@/Layouts/SideBar.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

    const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="min-h-screen bg-brown-100" id="auth_layout">
        <nav class="fixed w-full bg-brown-600 border-brown-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 left-3">
                <div class="flex justify-start md:h-5 sm:h-6">
                    <!-- Sidebar -->
                    <SideBar></SideBar>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>
    </div>
</template>
