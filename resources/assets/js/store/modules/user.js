import * as config from '../../config.js'

export default {
	namespaced: true,
	state: {
		auth: false,
		token: null,
		data: {
			email: null,
			name: null,
			avatar: null,
		},
	},

  getters: {
    isAuth: (state, getters, rootState, rootGetters) => {
    	return state.auth;
    }
  },

  actions: {
  	auth({commit}) {
	  	axios.post(config.url.auth)
		    .then(response => {
					const auth = response.data.auth;
					commit('set', { type: 'auth', value: auth })
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
