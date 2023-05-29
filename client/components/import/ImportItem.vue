<template>
  <div>
    <h4 class="mb-2">
      Import data
    </h4>
    <hr class="my-2-1">
    <b-row>
      <b-col>
        <usecsv-button
          importer-key="8589b08d-8d2c-4736-803b-e7cdd42d66e4"
          :user="{ userId: '12345' }"
          :on-data="onData"
        >
          Import Data
        </usecsv-button>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import UseCSVButton from '@usecsv/vuejs'

export default {
  name: 'ImportItem',
  components: { 'usecsv-button': UseCSVButton },
  data () {
    return {
      loading: false,
      success: false
    }
  },
  methods: {
    onData (data) {
      this.loading = true
      this.$axios.post('/api/items/import', data)
        .then(() => {
          this.$bvToast.toast('CSV import successful', {
            title: 'Success message',
            variant: 'success'
          })
          this.$router.push({ path: '/' })
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
