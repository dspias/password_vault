<template>
  <main>
    <div class="text-center text-sm-left">
      <h1 class="heading-6 mb-4 text-green font-weight-normal">
        Login
      </h1>
    </div>
    <ValidationObserver v-slot="{ invalid }">
      <b-form @submit.prevent="userLogin">
        <ValidationProvider v-slot="{ errors }" rules="required|email">
          <b-form-group class="form-group-material">
            <b-form-input
              id="login-email"
              v-model="login.email"
              placeholder="Email"
              type="text"
              name="email"
              :state="error.email || _.has(errors, '0') ? false : null"
              @change="removeSpace"
            />
            <label for="login-email">Email address</label>
            <b-form-invalid-feedback v-if="_.has(error, 'email.0') || _.has(errors, '0')" class="text-right">
              {{ _.get(error, 'email.0') || _.get(errors, '0') }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider v-slot="{ errors }" rules="required">
          <password-input
            id="login-password"
            v-model="login.password"
            placeholder="Password"
            name="password"
            :state="_.get(error, 'password.0') || _.get(errors, '0')"
            form-group-class="mb-0"
            :is-material="true"
          />
        </ValidationProvider>
        <div class="d-sm-flex justify-content-between text-center text-sm-left mt-3 pt-2">
          <div class="mt-4 mt-sm-0">
            <b-button variant="link" to="/forgotPassword" class="text-green px-0 fs--2">
              Forgot password?
            </b-button>
          </div>
          <loading-button :loading="loading" variant="green" :disabled="!isEnableSubmit || invalid" class="px-6 btn-block btn-sm-inline btn-xs-lg" type="submit">
            Login
          </loading-button>
        </div>
        <p class="fs--2 mt-3 mt-sm-5 mb-0 text-center text-sm-left">
          Don’t have any account yet?
          <router-link to="/register" class="text-green font-weight-medium">
            Signup
          </router-link>
        </p>
      </b-form>
    </ValidationObserver>
  </main>
</template>

<script>
import _ from 'lodash'
import { ValidationProvider, ValidationObserver } from 'vee-validate'

export default {
  components: {
    ValidationProvider,
    ValidationObserver
  },
  layout: 'auth',
  middleware: 'auth',
  auth: 'guest',
  data: () => ({
    loading: false,
    login: { email: '', password: '' },
    error: {}
  }),
  head () {
    return {
      title: 'Login'
    }
  },
  computed: {
    isEnableSubmit () {
      return !!(this.login.email && this.login.password)
    }
  },
  methods: {
    async userLogin () {
      this.loading = true
      this.$set(this, 'error', {})
      try {
        await this.$auth.loginWith('laravelSanctum', { data: this.login })
        this.$auth.redirect('home')
        this.loading = false
      } catch (e) {
        this.$set(this, 'error', _.get(e, 'response.data.errors', {}))
        this.loading = false
      }
    },
    removeSpace () {
      this.login.email = this.login.email.replace(/ /g, '')
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
