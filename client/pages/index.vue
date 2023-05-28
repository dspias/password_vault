<template>
  <b-row>
    <b-col md="3">
      <div class="rounded white-card p-3 mb-3 text-sm-left mt-3 mt-md-0">
        <b-row align-v="center">
          <b-col cols="12" class="text-black">
            <b class="text-black">All credentials</b>
            <p
              class="mb-0 mt-2 cursor-pointer"
              :class="{'text-green': selectedFolder === null}"
              @click="selectFolder()"
            >
              <b-icon-blockquote-left class="mr-1" /> All
            </p>
          </b-col>
          <b-col cols="12" class="text-black mt-2 d-flex justify-content-between">
            <b v-b-toggle.collapse-folders class="text-black cursor-pointer">
              <b-icon-arrow-down class="mr-1" /> Folders
            </b>
            <b v-b-modal.create-folder class="text-green">
              <b-icon-plus class="mr-1 fs-2 cursor-pointer" />
            </b>
          </b-col>
          <b-col md="12">
            <b-collapse id="collapse-folders" visible>
              <b-card class="border-0">
                <div v-for="folder in folders" :key="folder.id">
                  <div class="mt-2 d-flex justify-content-between">
                    <p
                      class="mb-0 cursor-pointer"
                      :class="{'text-green': selectedFolder === folder.id}"
                      @click="selectFolder(folder.id)"
                    >
                      <b-icon-folder class="mr-2" />{{ folder.name }}
                    </p>
                    <b class="text-green" @click="editFolderModelOpen(folder)">
                      <b-icon-pencil class="mr-1 fs-1 cursor-pointer" />
                    </b>
                  </div>
                </div>
                <p
                  class="mb-0 mt-2  cursor-pointer"
                  :class="{'text-green': selectedFolder === 'no'}"
                  @click="selectFolder('no')"
                >
                  <b-icon-folder class="mr-2" />No Folder
                </p>
              </b-card>
            </b-collapse>
          </b-col>
        </b-row>
      </div>
    </b-col>
    <b-col md="6">
      <div class="d-flex justify-content-between">
        <h4 class="mb-2">
          Items
        </h4>
        <b-button
          v-b-modal.create-item
          variant="green"
        >
          <b-icon-plus class="mr-1 fs-2 cursor-pointer" /> New item
        </b-button>
      </div>
      <hr class="my-2-1">
      <vault-items items.sync="items" />
    </b-col>
    <create-item-modal id="create-item" :folders.sync="folders" />
    <create-folder-modal id="create-folder" />
    <edit-folder-modal id="edit-folder" :folder.sync="editFolder" />
  </b-row>
</template>

<script>
export default {
  middleware: 'auth',
  async asyncData ({ $axios }) {
    const folders = await $axios.get('/api/folders').then(res => res.data)
    const items = await $axios.get('/api/items').then(res => res.data)
    return { folders, items }
  },
  data () {
    return {
      loading: false,
      success: false,
      error: {},
      editFolder: {},
      selectedFolder: null
    }
  },
  head () {
    return {
      title: 'Vault'
    }
  },
  watch: {
    selectedFolder: {
      handler (value) {
        this.$axios.get('api/items', { folder: this.selectedFolder })
          .then(res => res.data)
          .then((res) => {
            this.items = res
          })
        this.info = { ...value }
      }
    }
  },
  methods: {
    editFolderModelOpen (folder) {
      this.editFolder = { ...folder }
      this.$bvModal.show('edit-folder')
    },
    selectFolder (id = null) {
      this.selectedFolder = id
    }
  }
}
</script>

<style scoped lang="scss">
.white-card{
  border: 0.5px solid #D7D7D7;
}
</style>
