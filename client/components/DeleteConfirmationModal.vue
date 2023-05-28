<template>
  <custom-modal
    :id="id"
    body-class="p-3 p-sm-4-1"
  >
    <h5 class="font-weight-normal text-black mb-4 heading-line-height">
      {{ title }}
    </h5>
    <div class="about-empty rounded text-sm-left">
      <b-row align-v="center" no-gutters>
        <b-col md="12" class="text-black">
          <div class="fs--1 text-black text-700 mb-2" :class="{ 'mb-4': _.isEmpty(note) }">
            {{ message }}
          </div>
          <div v-if="!_.isEmpty(note)" class="fs--2 text-700 mb-4">
            <b-iconstack font-scale="1.2" class="mr-2">
              <b-icon stacked icon="square" />
              <b-icon stacked icon="check" class="text-green" />
            </b-iconstack>
            {{ note }}
          </div>
          <b-form-group class="mb-0">
            <b-button
              size="lg"
              variant="danger"
              class="px-5 border rounded cursor-pointer"
              @click="confirmedDelete()"
            >
              Yes
            </b-button>
            <b-button
              size="lg"
              variant="link"
              class="text-dark cursor-pointer"
              @click="hideModal"
            >
              No
            </b-button>
          </b-form-group>
        </b-col>
      </b-row>
    </div>
  </custom-modal>
</template>

<script>
export default {
  name: 'DeleteConfirmationModal',
  props: {
    id: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    message: {
      type: String,
      required: true
    },
    note: {
      type: String,
      default: null
    }
  },
  methods: {
    confirmedDelete () {
      this.hideModal()
      this.$emit('confirmed')
    },
    hideModal () {
      this.$bvModal.hide(this.id)
    }
  }
}
</script>

<style lang="scss" scoped>
  .heading-line-height {
    line-height: 140%;
  }
</style>
