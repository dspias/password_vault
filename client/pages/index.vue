<template>
  <b-row>
    <b-col md="3">
      <div class="rounded white-card p-3 mb-3 text-sm-left mt-3 mt-md-0">
        <b-row align-v="center">
          <b-col cols="12" class="text-black">
            <b class="text-green">All credentials</b>
            <p class="mb-0 mt-2">
              <b-icon-blockquote-left class="mr-1" /> All
            </p>
          </b-col>
          <b-col cols="12" class="text-black mt-2">
            <b v-b-toggle.collapse-folders class="text-green">
              <b-icon-arrow-down class="mr-1" /> Folders
            </b>
          </b-col>
          <b-col md="12">
            <b-collapse id="collapse-folders" visible>
              <b-card class="border-0">
                <p v-for="folder in folders" :key="folder.id" class="mb-0">
                  <b-icon-folder class="mr-2" />{{ folder.name }} asfas
                </p>
              </b-card>
            </b-collapse>
          </b-col>
        </b-row>
      </div>
    </b-col>
    <b-col md="6">
      asdf
    </b-col>
  </b-row>
</template>

<script>
export default {
  asyncData ({ $axios }) {
    return $axios.get('/api/folders')
      .then(res => res.data)
      .then((res) => {
        return { folders: res }
      })
  },
  head () {
    return {
      title: 'Vault'
    }
  }
}
</script>

<style scoped lang="scss">
.white-card{
  border: 0.5px solid #D7D7D7;
}
</style>
