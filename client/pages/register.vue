<template>
  <main>
    <div class="text-center text-sm-left">
      <h1 class="heading-6 mb-4 text-green font-weight-normal">
        Signup
      </h1>
    </div>
    <ValidationObserver v-slot="{ invalid }">
      <b-form @submit.prevent="registerUser">
        <ValidationProvider v-slot="{ errors }" rules="required|minmax:5,30">
          <b-form-group class="form-group-material">
            <b-form-input
              id="signup-name"
              v-model="info.name"
              placeholder="Name"
              type="text"
              name="name"
              :state="error.name || _.has(errors, '0') ? false : null"
            />
            <label for="signup-name">Your name</label>
            <b-form-invalid-feedback v-if="_.has(error, 'name.0') || _.has(errors, '0')" class="text-right">
              {{ _.get(error, 'name.0') || _.get(errors, '0') }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider v-slot="{ errors }" rules="required|email">
          <b-form-group class="form-group-material">
            <b-form-input
              id="signup-email"
              v-model="info.email"
              placeholder="Email"
              type="email"
              name="email"
              :state="error.email || _.has(errors, '0')? false : null"
            />
            <label for="signup-email">Email address</label>
            <b-form-invalid-feedback v-if="_.has(error, 'email.0') || _.has(errors, '0')" class="text-right">
              {{ _.get(error, 'email.0') || _.get(errors, '0') }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider v-slot="{ errors }" rules="required">
          <password-input
            id="signup-password"
            v-model="info.password"
            placeholder="Password"
            name="password"
            :state="_.get(error, 'password.0') || _.get(errors, '0')"
            form-group-class="mb-0"
            :is-material="true"
          />
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
            Create account
          </loading-button>
        </div>
        <p class="fs--2 mt-3 mb-0 text-center text-sm-left">
          Already have an account?
          <router-link to="/login" class="text-green font-weight-medium">
            Login
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
    ValidationProvider, ValidationObserver
  },
  layout: 'auth',
  middleware: 'auth',
  auth: 'guest',
  data: () => ({
    loading: false,
    success: false,
    info: {
      name: null,
      email: null,
      password: null
    },
    error: {}
  }),
  computed: {
    isEnableSubmit () {
      return !!(this.info.name && this.info.email && this.info.password)
    }
  },
  methods: {
    registerUser () {
      this.loading = true
      this.$axios.post('/api/auth/register', this.info)
        .then(async () => {
          await this.$auth.loginWith('laravelSanctum', {
            data: {
              email: this.info.email,
              password: this.info.password
            }
          })
          this.success = true
          this.$bvToast.toast('Signup successful', {
            title: 'Success message',
            variant: 'success'
          })
          this.$router.push({ path: '/step2/verify' })
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
