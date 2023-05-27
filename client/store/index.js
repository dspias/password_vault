export const state = () => ({
  auth: {},
  csrfInitialized: null
})

export const mutations = {
  csrfStatus (state, status) {
    state.csrfInitialized = status
  }
}

export const getters = {
  isAuthenticated (state) {
    return state.auth.loggedIn
  },

  loggedInUser (state) {
    return state.auth.user
  }
}
