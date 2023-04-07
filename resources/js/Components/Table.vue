<script setup>
  defineProps({
    header: Array,
    items: {
      type: Number,
      default: 0
    }
  })
</script>


<template>
  <div class="sm:w-auto" :class="items > 0 ? 'w-max' : 'w-full'">
    <table class="sm:table-fixed table-auto overflow-x-scroll w-full">
      <thead class="border-b border-gray-300">
        <tr>
          <th
            v-for="item in header" class="py-4 lg:text-base text-sm px-2"
            :class="{'hidden lg:block': !item.showInMobile }"
          >
            {{ item.name }}
          </th>
        </tr>
      </thead>
      <slot />
    </table>
  </div>
</template>
