export const state = () => ({
  auth: {},
  csrfInitialized: null
})

export const mutations = {
  csrfStatus (state, status) {
    state.csrfInitialized = status
  }
}
