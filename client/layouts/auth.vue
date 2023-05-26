<template>
  <section class="bg-gradient">
    <b-container :fluid="true">
      <b-row class="min-vh-sm-100">
        <b-col>
          <b-row class="flex-center d-flex min-vh-sm-100 pt-4 pt-md-7 pb-4">
            <b-col md="4">
              <div class="text-center">
                <nuxt-logo />
              </div>
              <h4 class="text-center mt-4">
                Welcome to Vault
              </h4>
              <nuxt />
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
export default {
}
</script>

<style scoped>
  .bg-gradient {
    background-image: linear-gradient(180deg, rgba(238, 246, 248, 0.6) 116.65%, rgba(239, 249, 248, 0) 180.87%);
  }
</style>
