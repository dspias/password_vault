<template>
  <section>
    <b-container>
      <b-row align-h="center" align-v="center" class="pt-6 pb-7 min-vh-50">
        <b-col sm="8" lg="6" class="text-center">
          <h4 height="300" class="mt-n4 mt-sm-n5 page-404 mb-4">
            404
          </h4>
          <div class="mt-n1 mt-sm-n4-1 mt-md-n3-1">
            <h1 class="font-weight-normal fs-2 fs-sm-3 mb-3 mb-sm-4 line-height-1">
              <span v-if="error.statusCode === 404">Sorry, page not found</span>
              <span v-else>An error occurred</span>
            </h1>
            <b-button
              size="lg"
              variant="green"
              class="px-3"
              to="/"
            >
              Back to Homepage
            </b-button>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
export default {
  props: {
    error: {
      type: Object,
      required: true
    }
  }
}
</script>

<style scoped lang="scss">
  @media (max-width: 576px) {
    .page-404 {
      height: 160px !important;
    }
  }
</style>
