import * as config from '../../config.js'
import VueCookie from 'vue-cookie'

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
    checkAuth: ({commit}, data) => {
      axios(config.url.checkAuth, {
          method: 'post',
          data: {
            token: VueCookie.get('token')
          }
        })
        .then(response => {
          if(response.data.token) {
            // AuthController. Check user, then login or something like
            VueCookie.set('token', response.data.token, { expires: '1Y' });
            commit('set', { type: 'userData', items: {token: response.data.token} })
          }
          console.log(1);
        })
        .catch(e => {
          throw e
        })
    },
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
