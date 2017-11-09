import * as config from '../../config.js'

export default {
  namespaced: true,
	state: {
		main: [],
		search: [],
	},

  getters: {
    getMainProducts: (state, getters, rootState, rootGetters) => {
    	return state.main;
    },
    search: (state, getters, rootState, rootGetters) => {
    	return state.search;
    },
  },

  actions: {
  	getMainProducts({commit}) {
	  	axios.get(config.url.products)
		    .then(response => {
					const products = response.data.products;
					commit('set', { type: 'main', items: products })
		    })
		    .catch(e => {
		      throw e
		    })
  	},
  	search({commit}, query) {
	  	axios.get(config.url.searchProducts + query)
		    .then(response => {
					const products = response.data.products;
					commit('set', { type: 'search', items: products })
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
