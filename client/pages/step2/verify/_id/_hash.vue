<template>
  <main>
    <div v-if="!error">
      <h1 class="fs-2 text-success mb-0 mb-md-2">
        Email verification successfull
      </h1>
      <div class="mt-3">
        <b-button variant="green" to="/" size="lg" class="px-4 fs-0" readonly>
          Vault
        </b-button>
      </div>
    </div>
    <div v-else class="text-center text-sm-left">
      <b-icon-exclamation-circle class="fs-6 text-danger" />
      <h1 class="fs-2 text-danger mt-3 mb-0 mb-md-2 font-weight-normal">
        {{ error }}
      </h1>
      <p class="fs--2 text-black" :style="{'max-width': '480px'}">
        Please contact support or go back and request a new email.
      </p>
      <div class="mt-4 mt-md-5">
        <b-button variant="green" to="/step2/verify" size="lg" class="px-4 fs-0 mr-2" readonly>
          Go Back
        </b-button>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: 'VerifyEmail',
  layout: 'auth',
  middleware: 'auth',
  data: () => ({
    error: null
  }),
  async fetch () {
    const { id, hash } = this.$route.params
    this.error = await this.$axios.get(`/api/auth/verify/${id}/${hash}`, { params: this.$route.query })
      .then(async () => {
        await this.$auth.fetchUser()
        return false
      })
      .catch((err) => {
        return err.response.data.message
      })
  },
  head () {
    return {
      title: !this.error ? 'Verification successful!' : 'Verification failed!'
    }
  }
}
</script>
