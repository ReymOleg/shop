import * as config from '../../config.js'

export default {
  namespaced: true,
  state: {
    auth: false,
    userData: {
      email: null,
      name: null,
      token: null,
    },
  },
  getters: {
    isAuth: (state, getters, rootState, rootGetters) => {
      return state.auth;
    },
    userData: (state, getters, rootState, rootGetters) => {
      return state.userData;
    },
  },
  actions: {
    login: ({commit}, data) => {
      axios(config.url.login, {
          method: 'post',
          data: data,
        })
        .then(response => {
          const user = response.data.user;
          commit('set', { type: 'auth', items: true })
          commit('set', { type: 'userData', items: {email: user.email, name: user.name} })
        })
        .catch(e => {
          throw e
        })
    },
    create: ({commit}, data) => {
      axios(config.url.createUser, {
          method: 'post',
          data: data,
        })
        .then(response => {
          const user = response.data.user;
          commit('set', { type: 'auth', items: true })
          commit('set', { type: 'userData', items: {email: user.email, name: user.name} })
        })
        .catch(e => {
          throw e
        })
    }
  },
  mutations: {
    set(state, { type, items }) {
      state[type] = items
    }
  },
}
