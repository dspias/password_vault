<template>
  <nav class="z-index default-navbar" :class="{[`fixed-${fixed}`]: fixed, [`absolute-${absolute}`]: absolute}">
    <b-container :fluid="fluid">
      <b-navbar toggleable="lg" type="light" class="px-0">
        <b-navbar-brand class="fs--1 font-weight-bold" to="/">
          <nuxt-logo classes="nav-logo" />
        </b-navbar-brand>
        <b-navbar-toggle target="nav-collapse" class="border-0 p-0 fs-2 text-black d-inline-flex d-lg-none" :style="{width: '20px'}">
          <template #default="{ expanded }">
            <b-img v-if="!expanded" src="@/assets/images/icons/menu.svg" alt="Menu close" width="20" />
            <b-img v-else src="@/assets/images/icons/x.svg" alt="Menu expanded" width="14" />
          </template>
        </b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="ml-auto py-lg-1">
            <b-button
              v-if="!isAuthenticated"
              variant="outline-green"
              :class="`order-lg-${topNavRoutes.length + 2}`"
              class="nav-item px-3 py-1 ml-lg-4-1 mb-3 mb-lg-0 text-nowrap"
              to="/register"
            >
              Create account
            </b-button>
            <b-nav-item
              v-if="!isAuthenticated"
              class="d-flex align-items-center px-0 py-3 py-lg-0 ml-lg-4-1"
              :class="`order-lg-${topNavRoutes.length + 1}`"
              link-classes="p-0"
              to="/login"
            >
              Login
            </b-nav-item>
            <profile-dropdown
              tag="b-nav-item"
              class="flex-column ml-lg-4-1"
              :class="`order-lg-${topNavRoutes.length + 2}`"
            />
            <b-nav-item
              v-for="(route, i) in topNavRoutes"
              :key="i"
              class="border-top border-lg-top-0 border-200 d-flex align-items-center text-nowrap px-0 py-3 py-lg-0 ml-lg-4-1"
              link-classes="p-0"
              :to="route.to"
            >
              {{ route.name }}
            </b-nav-item>
          </b-navbar-nav>
        </b-collapse>
        <div class="navbar-mobile-overlay" />
      </b-navbar>
    </b-container>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import buildTopNavRoute from '@/utils/buildTopNavRoute'

export default {
  name: 'TopNav',
  props: {
    fixed: {
      type: String,
      default: null
    },
    absolute: {
      type: String,
      default: null
    },
    fluid: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'loggedInUser']),
    topNavRoutes () {
      return [...buildTopNavRoute()]
    },
    auth () {
      return this.$store.state.auth
    }
  }
}
</script>

<style scoped lang="scss">
$green: #9b51e0 !default;
$black: #000000 !default;
.navbar-nav {
  .nav-link {
    color: $black;

    &:hover {
      color: $green;
    }
  }
}

.nuxt-link-exact-active {
  color: $green !important;
}

.z-index {
  z-index: 99;
}
.nav-logo {
  height: 20px;
}
</style>
