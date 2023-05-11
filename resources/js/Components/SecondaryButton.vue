<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 border border-yellow-800 hover:text-gray-500 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-yellow-400 focus:outline-none focus:yellow-500 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 bg-yellow-800 text-white"
    >
        <slot />
    </button>
</template>
