<script setup>
    import SideBar from '@/Layouts/SideBar.vue';
</script>

<template>
    <div class="min-h-screen bg-brown-100" id="auth_layout">
        <nav class="md:fixed w-full bg-brown-600 border-brown-100">
            <SideBar></SideBar>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow-lg " v-if="$slots.header">
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
