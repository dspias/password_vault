<template>
  <main>
    <div v-if="_.get($auth, 'user.emailVerified')">
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
      <h1 class="fs-2 text-black mb-0 mb-md-2 font-weight-normal">
        Hi, {{ _.get($auth, 'user.name') }}
      </h1>
      <p class="fs-1 fs-md-2 fs-lg-3 text-black">
        You have successfully created your account.
      </p>
      <p class="fs--2 mt-3 mt-sm-5 mb-0 text-600 text-center text-sm-left">
        We have already sent you an email to <b>{{ _.get($auth, 'user.email') }}</b>. Please verify your email using the
        link in
        the email. You can request another verification email if you did not receive one.
      </p>
      <div class="mt-3">
        <b-button variant="green" size="lg" class="px-4 fs-0" :disabled="resent" @click="resend">
          Resend verification email
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
    resent: false
  }),
  methods: {
    resend () {
      this.resent = true
      this.$axios.post('/api/auth/email/verification-notification')
        .then(() => {
          this.$bvToast.toast('The password reset email has been sent', {
            title: 'Success',
            variant: 'success'
          })
        })
        .catch((err) => {
          this.resent = false

          if (err.response.status === 429) {
            this.$bvToast.toast(
              'You made too many requests withing a short period of time. Wait for a minute and try again',
              {
                title: 'Error',
                variant: 'warning'
              })
          } else {
            this.$bvToast.toast(
              'Something unexpected happened. May be refresh the page and try again.',
              {
                title: 'Error',
                variant: 'warning'
              })
          }
        })
    },
    logOut () {
      this.$auth.logout()
        .then(() => {
          this.$auth.redirect('login')
        })
    }
  }
}
</script>

<style scoped lang="scss">
</style>
