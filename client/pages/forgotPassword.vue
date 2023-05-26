<template>
  <main v-if="!forgotPasswordEmailSend">
    <div class="text-center text-sm-left mb-4">
      <h1 class="heading-5 mb-3 text-black font-weight-normal">
        Forgot your password?
      </h1>
      <p class="text-800">
        Enter your email address & we will email you a reset link
      </p>
    </div>
    <ValidationObserver v-slot="{ invalid }">
      <b-form @submit.prevent="sendEmail">
        <ValidationProvider v-slot="{ errors }" rules="required|email">
          <b-form-group class="form-group-material mb-0">
            <b-form-input
              id="forget-email"
              v-model="info.email"
              placeholder="Email"
              type="email"
              name="email"
              :state="error.email || _.has(errors, '0') ? false : null"
            />
            <label for="forget-email">Email address</label>
            <b-form-invalid-feedback v-if="_.has(error, 'email.0') || _.has(errors, '0')" class="text-right">
              {{ _.get(error, 'email.0') || _.get(errors, '0') }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        <div class="text-center text-sm-left mt-3 pt-2">
          <loading-button
            :loading="loading"
            :success.sync="success"
            variant="green"
            :disabled="!isEnableSubmit || invalid"
            class="px-5 btn-block btn-sm-inline btn-xs-lg"
            type="submit"
          >
            Send reset link
          </loading-button>
        </div>
        <p class="fs--2 mt-4 mt-sm-5 mb-0 text-center text-sm-left">
          Already have an account?
          <router-link to="/login" class="text-green font-weight-medium">
            Login
          </router-link>
        </p>
      </b-form>
    </ValidationObserver>
  </main>
  <main v-else>
    <h1 class="fs-2 text-black mb-0 mb-md-2">
      Success
    </h1>
    <p class="fs-1 fs-md-2 fs-lg-3 mb-0 font-weight-light text-black">
      The password reset email has been sent to your email
    </p>
    <div class="mt-4 mt-md-4-1">
      <b-button
        :href="domainUrl"
        target="_blank"
        rel="noopener"
        variant="green"
        size="lg"
        class="px-4 px-md-5 fs-0"
        :aria-readonly="true"
      >
        Open you email
      </b-button>
    </div>
    <p class="fs--2 mt-3 mt-sm-4-1 mb-0 text-center text-sm-left">
      Your email address {{ info.email }}
    </p>
  </main>
</template>

<script>
import _ from 'lodash'
import { ValidationProvider, ValidationObserver } from 'vee-validate'

export default {
  components: {
    ValidationProvider, ValidationObserver
  },
  layout: 'auth',
  middleware: 'auth',
  auth: 'guest',
  data: () => ({
    loading: false,
    success: false,
    forgotPasswordEmailSend: false,
    info: {
      email: ''
    },
    error: {}
  }),
  head () {
    return {
      title: 'Reset Password'
    }
  },
  computed: {
    isEnableSubmit () {
      return !!(this.info.email)
    },
    domainUrl () {
      let emailDomain = null
      const pos = this.info.email.search('@')
      if (pos > 0) {
        emailDomain = 'https://' + this.info.email.slice(pos + 1)
      }

      return emailDomain
    }
  },
  methods: {
    sendEmail () {
      this.loading = true
      this.$axios.post('/api/auth/forgot-password', this.info)
        .then(() => {
          this.$bvToast.toast('The password reset email has been sent', {
            title: 'Success message',
            variant: 'success'
          })
          this.success = true
          this.forgotPasswordEmailSend = true
        })
        .catch((e) => {
          this.$set(this, 'error', _.get(e, 'response.data.errors', {}))
          this.$bvToast.toast('Something wrong', {
            title: 'Error message',
            variant: 'danger'
          })
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
