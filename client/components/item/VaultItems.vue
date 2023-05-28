<template>
  <div>
    <b-table
      :items="items"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      sort-icon-left
      :no-border-collapse="false"
      show-empty
      responsive
      @row-clicked="rowItemClicked"
    >
      <template #cell(actions)="row">
        <div>
          <b-dropdown
            variant="link"
            toggle-class="p-0 ml-3"
            right
            no-caret
          >
            <template #button-content>
              <b-icon-three-dots-vertical class="text-600" />
            </template>
            <b-dropdown-item v-b-modal="`item-delete-confirmation-${row.item.id}`">
              Delete
            </b-dropdown-item>
            <delete-confirmation-modal
              :id="`item-delete-confirmation-${row.item.id}`"
              title="Delete Item?"
              message="Are you sure you want to delete the Item?"
              note="Credentials will be loss item data"
              @confirmed="destroyItem(row.item.id)"
            />
          </b-dropdown>
        </div>
      </template>
    </b-table>
    <b-row>
      <b-col sm="7" md="6" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="items.length"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
        />
      </b-col>
    </b-row>
    <update-item-modal
      id="edit-item"
      :item.sync="editItem"
      :folders="folders"
      @updateItem="updateItems => $emit('updateItem', updateItems)"
    />
  </div>
</template>

<script>
export default {
  name: 'VaultItems',
  props: {
    items: {
      type: Array,
      default: () => []
    },
    folders: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      editItem: {
        name: null,
        folder_id: null,
        username: null,
        password: null,
        notes: null
      },
      currentPage: 1,
      perPage: 15
    }
  },
  computed: {
    fields () {
      return [
        { key: 'name', label: 'Name', sortable: true },
        { key: 'folder.name', label: 'Folder' },
        { key: 'username', label: 'Username', sortable: true },
        { key: 'actions', label: 'Action' }
      ]
    }
  },
  methods: {
    rowItemClicked (item) {
      this.editItem = { ...item }
      this.$bvModal.show('edit-item')
    },
    async destroyItem (id) {
      try {
        const response = await this.$axios.delete(`/api/items/delete/${id}`)
          .then(response => response.data)
        this.$bvToast.toast('Item deleted', {
          title: 'Success message',
          variant: 'success'
        })
        this.$emit('updateItem', response)
      } catch (e) {
        this.$set(this, 'error', _.get(e, 'response.data.errors', {}))
        const notifications = Object.values(_.get(e, 'response.data.errors', {}))
        notifications.forEach(notification =>
          this.$bvToast.toast(notification, {
            title: 'Something wrong',
            variant: 'danger'
          })
        )
      }
    }
  }
}
</script>

<style lang="scss">
.b-table tbody tr {
  cursor: pointer;
}
</style>
