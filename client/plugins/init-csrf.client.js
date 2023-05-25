export default ({ store, app }) => {
  app.$axios.get('/api/sanctum/csrf-cookie')
    .then(() => {
      store.commit('csrfStatus', true)
    })
    .catch(() => {
      store.commit('csrfStatus', false)
    })
}
