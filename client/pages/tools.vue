<template>
  <b-row>
    <b-col md="3">
      <b-nav vertical class="w-100">
        <b-nav-item
          class="fs-1 text-black"
          active-class="active"
          :active="tab === 'generator'"
          @click="selectTab('generator')"
        >
          Generator
        </b-nav-item>
        <b-nav-item
          class="fs-1 text-black"
          active-class="active"
          :active="tab === 'import'"
          @click="selectTab('import')"
        >
          Import
        </b-nav-item>
        <b-nav-item
          class="fs-1 text-black"
          active-class="active"
          :active="tab === 'export'"
          @click="selectTab('export')"
        >
          Export
        </b-nav-item>
      </b-nav>
    </b-col>
    <b-col md="9">
      <password-generator v-if="tab === 'generator'" />
      <import-item v-if="tab === 'import'" />
      <export-item v-if="tab === 'export'" />
    </b-col>
  </b-row>
</template>

<script>
import PasswordGenerator from '../components/generator/PasswordGenerator.vue'
export default {
  components: { PasswordGenerator },
  data () {
    return {
      tab: 'generator'
    }
  },
  head () {
    return {
      title: 'Tools'
    }
  },
  methods: {
    selectTab (name) {
      this.tab = name
    }
  }
}
</script>

<style lang="scss">
.active {
  background-color: #9b51e0;
  color: #ffffff !important;
}
</style>
