<template>
  <div>
    <div class="d-flex justify-content-between">
      <h4 class="mb-2">
        Export Vault
      </h4>
      <b-button
        v-b-modal.create-item
        variant="green"
      >
        <b-icon-plus class="mr-1 fs-2 cursor-pointer" /> New item
      </b-button>
    </div>
    <hr class="my-2-1">
  </div>
</template>

<script>
export default {
  name: 'ExportItem',
  data () {
    return {
    }
  }
}
</script>
