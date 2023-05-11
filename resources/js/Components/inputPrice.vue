<script setup>
import { reactive, ref, computed } from 'vue';
import { number } from '@coders-tm/vue-number-format'

const numbers = reactive({
  decimal: '.',
  separator: ',',
  prefix: '$ ',
  precision: 2,
  minimumFractionDigits: 2
});


const props = defineProps({
  value: String | Number,
  disabled: {
    type: Boolean,
    default: false
  }
});


const emit = defineEmits(['update:value']);

const proxyPrice = computed({
  get() {
    return props.value;
  },

  set(val) {
    emit('update:value', Number(val));
  },
});

const input = ref(null);

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <number
    ref="input"
    class="rounded-md border-gray-50 focus:border-gray-400 hover:border-gray-400 focus:ring hover:ring focus:ring-gray-300 hover:ring-gray-300 focus:ring-opacity-50 hover:ring-opacity-50  shadow-sm disabled:bg-slate-100"
    v-model="proxyPrice"
    v-bind="numbers"
    :disabled="disabled"
  />
</template>
