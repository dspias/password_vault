<template>
  <div>
    <p v-for="item in items" :key="item.id">
      {{ item.name }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'VaultItems',
  props: {
    items: {
      type: Array,
      default: () => []
    }
  }
}
</script>
