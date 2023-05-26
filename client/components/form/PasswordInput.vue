<template>
  <b-form-group :class="{[formGroupClass]: formGroupClass, 'form-group-material': isMaterial}">
    <label v-if="showLabel && !isMaterial" :for="id">{{ label }}</label>
    <div class="position-relative">
      <b-button variant="link" class="p-0 password-show-hide fs--2" :class="{'mr-2': !isMaterial}" type="button" @click="showPassword = !showPassword">
        <b-icon-eye-fill v-if="!showPassword" class="text-400" />
        <b-icon-eye-slash-fill v-else class="text-700" />
      </b-button>
      <b-form-input
        :id="id"
        :placeholder="placeholder"
        :type="showPassword ? 'text' : 'password'"
        :name="name"
        :value="inputValue"
        :state="state ? false : null"
        :required="isRequired"
        @input="value => $emit('input', value)"
      />
      <label v-if="placeholder && isMaterial" :for="id">{{ placeholder }}</label>
    </div>
    <b-form-invalid-feedback v-if="state" class="text-right" :class="{'d-block': state}">
      {{ state }}
    </b-form-invalid-feedback>
  </b-form-group>
</template>

<script>
export default {
  name: 'PasswordInput',
  model: {
    prop: 'inputValue',
    event: 'input'
  },
  props: {
    inputValue: {
      type: [String, Number],
      default: ''
    },
    id: {
      type: [String, Number],
      required: true
    },
    showLabel: {
      type: Boolean,
      default: false
    },
    label: {
      type: String,
      default: ''
    },
    isRequired: {
      type: Boolean,
      default: false
    },
    state: {
      type: String,
      default: ''
    },
    isMaterial: {
      type: Boolean,
      default: false
    },
    name: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      default: null
    },
    formGroupClass: {
      type: String,
      default: ''
    }
  },
  data: () => ({
    showPassword: false
  })
}
</script>

<style scoped lang="scss">
  .password-show-hide {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translate3d(0, -50%, 0);
    z-index: 1;
  }
</style>
