import * as config from '../../config.js'
import VueCookie from 'vue-cookie'

export default {
  namespaced: true,
  state: {
    auth: false,
    userData: {
      email: null,
      name: null
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
          const data = response.data;
          if(data.auth) {
            commit('set', { type: 'auth', items: true })
          }
          if(data.user) {
            commit('set', { type: 'userData', items: {email: data.user.email, name: data.user.name} })
          }
          if(data.token) {
            VueCookie.set('token', response.data.token, { expires: '1Y' });
          }
        })
        .catch(e => {
          throw e
        })
    },
    login: ({commit}, data) => {
      return new Promise((resolve, reject) => {
        axios(config.url.login, {
            method: 'post',
            data: data,
          })
          .then(response => {
            const data = response.data;
            if(data.auth) {
              commit('set', { type: 'auth', items: true })
            }
            if(data.user) {
              commit('set', { type: 'userData', items: {email: data.user.email, name: data.user.name} })
            }
            if(data.token) {
              VueCookie.set('token', response.data.token, { expires: '1Y' });
            }

            resolve(response);
          })
          .catch(e => {
            reject(e);
            throw e
          })
        })
    },
    create: ({commit}, data) => {
      return new Promise((resolve, reject) => {
        axios(config.url.createUser, {
            method: 'post',
            data: data,
          })
          .then(response => {
            const user = response.data.user;
            if(user) {
              commit('set', { type: 'auth', items: true })
              commit('set', { type: 'userData', items: {email: user.email, name: user.name} })
            }
            if(response.data.token) {
              VueCookie.set('token', response.data.token, { expires: '1Y' });
            }
            resolve(response);
          })
          .catch(e => {
            reject(e.response);
            throw e
          })
      })
    },
    logout: ({commit}, data) => {
      return new Promise((resolve, reject) => {
        axios(config.url.logout, {
            method: 'post',
            data: data,
          })
          .then(response => {
            const data = response.data;
            commit('set', { type: 'auth', items: false })
            commit('set', { type: 'userData', items: {email: null, name: null} })
            if(data.token) {
              VueCookie.set('token', response.data.token, { expires: '1Y' });
            }
            resolve(response);
          })
          .catch(e => {
            reject(e);
            throw e
          })
      })
    },
  },
  mutations: {
    set(state, { type, items }) {
      state[type] = items
    }
  },
}
