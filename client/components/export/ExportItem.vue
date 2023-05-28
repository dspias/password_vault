<template>
  <div>
    <h4 class="mb-2">
      Export Vault
    </h4>
    <hr class="my-2-1">
    <b-row>
      <b-col>
        <b-link href="/api/csv/export">
          Download vault as SVG
        </b-link>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'ExportItem',
  data () {
    return {
      loading: false,
      success: false
    }
  },
  methods: {
    submit () {
      this.loading = true
      this.$axios.post('/api/csv/export')
        .then((res) => {
        })
        .catch((e) => {
          this.$set(this, 'error', _.get(e, 'response.data.errors', {}))
          this.$bvToast.toast('Something wrong', {
            title: 'Error message',
            variant: 'danger'
          })
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
