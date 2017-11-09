import * as config from '../../config.js'

export default {
  namespaced: true,
	state: {
		main: [],
		searchAutocomplete: [],
		loadedProducts: [],
	},

  getters: {
    getMainProducts: (state, getters, rootState, rootGetters) => {
    	return state.main;
    },
    searchAutocomplete: (state, getters, rootState, rootGetters) => {
    	return state.searchAutocomplete;
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
  	searchAutocomplete({commit}, query) {
	  	axios.get(config.url.searchAutocomplete + query)
		    .then(response => {
					const products = response.data.products;
					commit('set', { type: 'searchAutocomplete', items: products })
		    })
		    .catch(e => {
		      throw e
		    })
  	},
  	getProduct({commit}, url) {

  	}
  },

  mutations: {
		set(state, { type, items }) {
			state[type] = items
		}
	},
}
