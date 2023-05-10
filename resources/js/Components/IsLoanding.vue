<script setup>
import Loading from 'vue3-loading-overlay';

const props = defineProps({
    isLoading: Boolean
});

</script>
<template>
    <div>

        <div v-if="props.isLoading"
                class=" absolute w-full bg-gray-200 bg-opacity-80 h-full bottom-0 right-0 top-0 grid place-content-center">
                <Loading class="" :active.sync="props.isLoading"></Loading>
            </div>
    </div>
</template>
