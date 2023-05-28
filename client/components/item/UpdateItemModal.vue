<template>
  <custom-modal
    :id="id"
    body-class="p-3 p-sm-4-1"
  >
    <h6 class="font-weight-normal text-green mb-4 heading-line-height">
      Edit Item
    </h6>
    <div>
      <ValidationObserver v-slot="{ invalid }">
        <b-row align-v="center">
          <b-col md="6">
            <ValidationProvider v-slot="{ errors }" rules="required|min:2">
              <b-form-group class="form-group-material">
                <b-form-input
                  id="name"
                  v-model="info.name"
                  type="text"
                  name="name"
                  placeholder="Folder"
                  :state="error.name || _.has(errors, '0') ? false : null"
                />
                <label for="name">Item name*</label>
                <b-form-invalid-feedback v-if="_.has(error, 'name.0') || _.has(errors, '0')" class="text-right">
                  {{ _.get(error, 'name.0') || _.get(errors, '0') }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col md="6">
            <ValidationProvider v-slot="{ errors }">
              <b-form-group class="form-group-material">
                <label for="folder_id">Select folder</label>
                <b-form-select
                  id="folder_id"
                  v-model="info.folder_id"
                  name="folder_id"
                  class="form-control"
                  :options="folderOptions"
                  :state="error.folder_id || _.has(errors, '0') ? false : null"
                />
                <b-form-invalid-feedback v-if="_.has(error, 'folder_id.0') || _.has(errors, '0')" class="text-right">
                  {{ _.get(error, 'folder_id.0') || _.get(errors, '0') }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col md="6">
            <ValidationProvider v-slot="{ errors }" rules="required|min:2">
              <b-form-group class="form-group-material">
                <b-form-input
                  id="username"
                  v-model="info.username"
                  type="text"
                  name="username"
                  placeholder="Username"
                  :state="error.username || _.has(errors, '0') ? false : null"
                />
                <label for="username">Username*</label>
                <b-form-invalid-feedback v-if="_.has(error, 'username.0') || _.has(errors, '0')" class="text-right">
                  {{ _.get(error, 'username.0') || _.get(errors, '0') }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col md="6">
            <ValidationProvider v-slot="{ errors }" rules="required">
              <b-form-group class="form-group-material">
                <password-input
                  id="login-password"
                  v-model="info.password"
                  placeholder="Password*"
                  name="password"
                  :state="_.get(error, 'password.0') || _.get(errors, '0')"
                  form-group-class="mb-0"
                  :is-material="true"
                />
                <b-form-invalid-feedback v-if="_.has(error, 'username.0') || _.has(errors, '0')" class="text-right">
                  {{ _.get(error, 'username.0') || _.get(errors, '0') }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
          </b-col>
          <b-col md="12">
            <ValidationProvider v-slot="{ errors }" rules="min:5">
              <b-form-group class="mb-4">
                <label for="notes" class="fs--2 text-muted">Notes</label>
                <b-form-textarea
                  id="notes"
                  v-model="info.notes"
                  class="border-x-0 border-top-0 rounded-0 px-0"
                  name="notes"
                  placeholder="Type here"
                  :state="error.notes || _.has(errors, 'notes.0') ? false : null"
                  rows="2"
                />
                <b-form-invalid-feedback v-if="_.has(error, 'notes.0') || _.has(errors, '0')" class="text-right">
                  {{ _.get(error, 'notes.0') || _.get(errors, '0') }}
                </b-form-invalid-feedback>
              </b-form-group>
            </ValidationProvider>
          </b-col>
        </b-row>
        <b-form-group class="mb-0">
          <loading-button
            :disabled="invalid || !isEnableSubmit"
            size="lg"
            variant="green"
            class="mr-2 px-4"
            @click="submit"
          >
            Update
          </loading-button>
          <b-button
            size="lg"
            variant="link"
            class="text-black font-weight-normal px-0 ml-3"
            @click="$bvModal.hide(id)"
          >
            Cancel
          </b-button>
        </b-form-group>
      </ValidationObserver>
    </div>
  </custom-modal>
</template>

<script>
import _ from 'lodash'
import { ValidationProvider, ValidationObserver } from 'vee-validate'

export default {
  name: 'UpdateItemModal',
  components: {
    ValidationProvider, ValidationObserver
  },
  props: {
    id: {
      type: String,
      required: true
    },
    item: {
      type: Object,
      required: true
    },
    folders: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      loading: false,
      success: false,
      error: {},
      info: {
        name: null,
        folder_id: null,
        username: null,
        password: null,
        notes: null
      }
    }
  },
  computed: {
    isEnableSubmit () {
      return !!(this.info.name && this.info.username && this.info.password)
    },
    folderOptions () {
      const folders = this.folders.map((folder) => {
        return { text: folder.name, value: folder.id }
      })
      folders.splice(0, 0, { text: 'Select folder', value: null })
      folders.push({ text: 'No Folder', value: 'no' })
      return folders
    }
  },
  watch: {
    item: {
      handler (value) {
        this.info = { folder_id: _.get(value, 'folder.id', null), ...value }
      },
      deep: true,
      immediate: true
    }
  },
  methods: {
    submit () {
      this.loading = true
      this.$axios.put(`/api/items/update/${this.info.id}`, this.info)
        .then(() => {
          this.info = {
            name: null,
            folder_id: null,
            username: null,
            password: null,
            notes: null
          }
          this.$bvModal.hide(this.id)
          this.$router.push({ name: 'index' })
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

<style lang="scss" scoped>
  .heading-line-height {
    line-height: 140%;
  }
</style>
