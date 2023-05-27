<template>
  <div class="is-default-navbar" :class="{'is-home': $route.name === 'index'}">
    <div class="default-navbar-standard">
      <top-nav class="bg-white navbar-shadow" />
    </div>
    <nuxt />
  </div>
</template>

<script>

export default {
}
</script>

<style scoped>
  .navbar-shadow {
    box-shadow: 0 4px 21px rgba(0, 0, 0, 0.04);
  }
</style>
