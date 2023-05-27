<template>
  <b-dropdown
    v-if="auth.loggedIn"
    :variant="variant"
    :toggle-class="toggleClass"
    :no-caret="noCaret"
    right
  >
    <template #button-content>
      <b-avatar src="@/assets/images/generic/placeholder-profile.jpg" size="sm" class="bg-300 mr-2" /> {{ firstName }}
    </template>
    <b-dropdown-item class="text-danger" @click="$auth.logout()">
      Logout
    </b-dropdown-item>
  </b-dropdown>
</template>

<script>
import _ from 'lodash'

export default {
  name: 'ProfileDropdown',
  props: {
    variant: {
      type: String,
      default: 'link'
    },
    toggleClass: {
      type: String,
      default: 'px-0 mb-2 mb-lg-0 fs--1 font-weight-normal text-black d-flex align-items-center'
    },
    noCaret: {
      type: Boolean,
      default: true
    }
  },
  computed: {
    firstName () {
      if (!this.auth.loggedIn) { return '' }
      return _.split(this.auth.user.name, ' ')[0]
    },
    auth () {
      return this.$store.state.auth
    }
  }
}
</script>

<style scoped>

</style>
