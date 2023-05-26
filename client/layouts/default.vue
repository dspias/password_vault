<template>
  <div class="is-default-navbar" :class="{'is-home': $route.name === 'index'}">
    <div class="default-navbar-standard">
      <top-nav class="bg-white navbar-shadow" />
    </div>
    <nuxt />
    <get-started v-if="getStarted.progress < 100 && $route.name !== 'profiles-edit'" :get-started="getStarted"/>
    <site-footer />
  </div>
</template>

<script>
import _ from 'lodash'

export default {
  asyncData ({ $axios }) {
    return $axios.get('/api/menus')
      .then((response) => {
        return { menus: response.data }
      })
  },
  computed: {
    getStarted () {
      const profile = _.get(this.$store, 'state.auth.user.profile', null)
      const getStarted = {
        progress: 0,
        avatar: false,
        title: false,
        preference: false,
        review: false,
        project: false,
        url_id: null
      }
      if (profile !== null && profile.type === 'freelancer') {
        getStarted.url_id = profile.url_id
        if (_.get(profile, 'avatar', false)) {
          getStarted.progress += 20
          getStarted.avatar = true
        }
        if (_.get(profile, 'title', false) && _.get(profile.tags, 'length', 0) >= 1) {
          getStarted.progress += 20
          getStarted.title = true
        }
        if (this.checkPreference(profile.meta)) {
          getStarted.progress += 20
          getStarted.preference = true
        }
        if (profile.reviews_count >= 1) {
          getStarted.progress += 20
          getStarted.review = true
        }
        if (_.get(profile, 'latest_review', false)) {
          getStarted.progress += 20
          getStarted.project = true
        }
      } else {
        getStarted.progress = 100
      }
      return getStarted
    }
  },
  methods: {
    checkPreference (meta) {
      let result = true
      const preferences = ['job_category', 'can_relocate', 'salary_range', 'experience', 'minimum_price', 'hourly_rate', 'weekly_hour', 'work_availability']
      preferences.forEach((preference) => {
        if (!_.has(meta, preference)) {
          result = false
        }
      })
      return result
    }
  }
}
</script>

<style scoped>
  .navbar-shadow {
    box-shadow: 0 4px 21px rgba(0, 0, 0, 0.04);
  }
</style>
