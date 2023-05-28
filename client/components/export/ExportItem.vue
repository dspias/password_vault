<template>
  <div>
    <h4 class="mb-2">
      Export Vault
    </h4>
    <hr class="my-2-1">
    <b-row>
      <b-col>
        <loading-button
          size="lg"
          variant="green"
          class="mr-2 px-4"
          @click="submit"
        >
          Download vault as SVG
        </loading-button>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import _ from 'lodash'
import json2csv from 'json2csv'

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
      this.$axios.get('/api/items')
        .then(res => res.data)
        .then((res) => {
          const data = res.map((item) => {
            return { ...item, folder: _.get(item, 'folder.name', '') }
          })
          // Convert data to CSV format
          const csv = json2csv.parse(data)

          // Create a temporary anchor element
          const element = document.createElement('a')
          element.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv)
          element.download = 'vault_items.csv'
          element.style.display = 'none'

          // Append the anchor element to the DOM
          document.body.appendChild(element)

          // Simulate a click to trigger the download
          element.click()

          // Remove the anchor element from the DOM
          document.body.removeChild(element)
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
