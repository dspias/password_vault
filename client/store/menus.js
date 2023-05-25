import Vue from 'vue'

export const state = () => ({
  data: []
})

export const mutations = {
  menus (state, menus) {
    Vue.set(state, 'data', menus)
  }
}

export const getters = {
  topNavRoutes (state) {
    return state.data.find(function (menu) {
      // eslint-disable-next-line unicorn/prefer-includes
      return menu.slug === 'auth-menu'
    })
  }
}

export const actions = {
  async load ({ commit }) {
    return await this.$axios.get('api/menus')
      .then((res) => {
        commit('menus', res.data)
      })
  }
}
