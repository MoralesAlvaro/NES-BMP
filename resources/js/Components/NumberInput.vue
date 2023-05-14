<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: Number,
        required: true,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-md shadow-sm border-amber-900 focus:border-amber-900 focus:ring focus:ring-amber-900 focus:ring-opacity-25 placeholder-gray-400 text-sm h-8"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>
