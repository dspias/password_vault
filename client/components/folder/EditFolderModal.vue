<template>
  <custom-modal
    :id="id"
    body-class="p-3 p-sm-4-1"
  >
    <h6 class="font-weight-normal text-green mb-4 heading-line-height">
      Edit Folder
    </h6>
    <div>
      <ValidationObserver v-slot="{ invalid }">
        <b-row align-v="center">
          <b-col md="12">
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
                <label for="name">Folder name</label>
                <b-form-invalid-feedback v-if="_.has(error, 'name.0') || _.has(errors, '0')" class="text-right">
                  {{ _.get(error, 'name.0') || _.get(errors, '0') }}
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
          <b-button
            size="lg"
            variant="link"
            class="text-danger cursor-pointer"
            @click="destroy"
          >
            Delete
          </b-button>
        </b-form-group>
      </ValidationObserver>
    </div>
  </custom-modal>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
export default {
  name: 'EditFolderModal',
  components: {
    ValidationProvider, ValidationObserver
  },
  props: {
    id: {
      type: String,
      required: true
    },
    folder: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
      loading: false,
      success: false,
      error: {},
      info: { name: null }
    }
  },
  computed: {
    isEnableSubmit () {
      return !!this.info.name
    }
  },
  watch: {
    folder: {
      handler (value) {
        this.info = { ...value }
      },
      deep: true,
      immediate: true
    }
  },
  methods: {
    submit () {
      this.loading = true
      this.$axios.put(`/api/folders/update/${this.info.id}`, this.info)
        .then(() => {
          this.$bvModal.hide(this.id)
          this.$bvToast.toast('Folder updated successfully', {
            title: 'Success message',
            variant: 'success'
          })
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
    },
    destroy () {
      this.loading = true
      this.$axios.delete(`/api/folders/delete/${this.info.id}`)
        .then(() => {
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
