<template>
  <b-modal
    :id="id"
    :ref="id"
    modal-class="custom-modal"
    dialog-class="custom-modal-dialog"
    v-bind="$attrs"
    centered
    hide-footer
    hide-header
    @hide="hide()"
  >
    <b-button class="modal-close" variant="link" @click="hideModal">
      <b-icon-x />
    </b-button>

    <slot />
  </b-modal>
</template>

<script>
export default {
  name: 'CustomModal',
  props: {
    id: {
      type: String,
      required: true
    }
  },
  methods: {
    hideModal () {
      this.$refs[this.id].hide()
    },
    hide () {
      this.$emit('hide', this.id)
    }
  }
}
</script>

<style lang="scss">
  .custom-modal {
    padding: 0 !important;

    &-dialog {
      padding: 8px !important;
      max-width: 600px;
    }
  }
  .modal-open {
    padding-right: 0px !important;
  }
</style>

<style lang="scss" scoped>
  .modal-close {
    position: absolute;
    top: 0;
    right: 0;
    font-size: 19px;
    line-height: 0;
    color: #088952;
    padding: 9px;
  }

  .custom-modal-dialog {
    max-width: 600px;
  }
</style>
