<template>
  <main>
    <div class="text-center text-sm-left mb-4">
      <h1 class="heading-5 mb-1 text-black font-weight-normal">
        Reset password
      </h1>
      <p>Enter your new password, confirm it and save changes</p>
    </div>
    <ValidationObserver v-slot="{ invalid }">
      <b-form @submit.prevent="reset">
        <ValidationProvider v-slot="{ errors }" rules="required">
          <b-form-group class="form-group-material">
            <b-form-input
              id="reset-password"
              v-model="info.password"
              placeholder="New password"
              type="password"
              name="password"
              :state="error.password || _.has(errors, '0') ? false : null"
            />
            <label for="reset-password">New password</label>
            <b-form-invalid-feedback v-if="_.has(error, 'password.0') || _.has(errors, '0')" class="text-right">
              {{ _.get(error, 'password.0') || _.get(errors, '0') }}
            </b-form-invalid-feedback>
          </b-form-group>
        </ValidationProvider>
        <ValidationProvider v-slot="{ errors }" rules="required">
          <b-form-group class="form-group-material mb-0">
            <b-form-input
              id="reset-confirm-password"
              v-model="info.password_confirmation"
              placeholder="Confirm new password"
              type="password"
              name="password_confirmation"
              :state="error.password_confirmation || _.has(errors, '0') ? false : null"
            />
            <label for="reset-confirm-password">Confirm new password</label>
            <b-form-invalid-feedback v-if="_.has(error, 'password_confirmation.0') || _.has(errors, '0')" class="text-right">
              {{ _.get(error, 'password_confirmation.0') || _.get(errors, '0') }}
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
            Save changes
          </loading-button>
        </div>
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
  asyncData ({ params: { token }, query: { email } }) {
    return {
      info: {
        email,
        token,
        password: '',
        password_confirmation: ''
      }
    }
  },
  data: () => ({
    loading: false,
    success: false,
    error: {}
  }),
  head () {
    return {
      title: 'Reset Password'
    }
  },
  computed: {
    isEnableSubmit () {
      return !!(this.info.password && this.info.password_confirmation)
    }
  },
  methods: {
    reset () {
      this.loading = true
      this.$axios.post('/api/auth/reset-password', this.info)
        .then(() => {
          this.success = true
          this.$bvToast.toast('The password was reset', {
            title: 'Success message',
            variant: 'success'
          })
          this.$auth.redirect('login')
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
