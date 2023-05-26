<template>
  <b-button :disabled="loading || disabled || success" :variant="variant" v-bind="$attrs" @click="e => this.$emit('click', e)">
    <span v-if="loading" class="px-3">
      <b-spinner
        class="border-2x"
        variant="light"
        small
      />
    </span>
    <span v-else-if="success" class="px-3">
      <b-icon-check2 />
    </span>
    <slot v-else />
  </b-button>
</template>

<script>
export default {
  name: 'LoadingButton',
  props: {
    loading: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    success: {
      type: Boolean,
      default: false
    },
    variant: {
      type: String,
      default: ''
    }
  },
  data: () => ({
    timer: null
  }),
  watch: {
    success (value) {
      if (value) {
        this.timer = setTimeout(() => {
          this.$emit('update:success', false)
        }, 2000)
      }
    }
  }
}
</script>
