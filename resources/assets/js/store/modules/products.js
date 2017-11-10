import * as config from '../../config.js'

export default {
  namespaced: true,
	state: {
		main: [],
		searchAutocomplete: [],
		loadedByUrl: {},
		currentProductUrl: null,
	},
  getters: {
    getMainProducts: (state, getters, rootState, rootGetters) => {
    	return state.main;
    },
    searchAutocomplete: (state, getters, rootState, rootGetters) => {
    	return state.searchAutocomplete;
    },
    getProductOfUrl(state, getters, rootState, rootGetters) {
    	// console.log(state.loadedByUrl[state.currentProductUrl])
  		return state.loadedByUrl[state.currentProductUrl] || {};
  		// return state.loadedByUrl;
  	}
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
  		// commit('setLoadedProduct', { type: 'loadedByUrl', item: {}, url: url })
  		axios.get(config.url.product + url)
		    .then(response => {
					const product = response.data.product;
					commit('set', { type: 'currentProductUrl', items: url })
					commit('setLoadedProduct', { type: 'loadedByUrl', item: product[0], url: url })
		    })
		    .catch(e => {
		      throw e
		    })
  	}
  },
  mutations: {
		set(state, { type, items }) {
			state[type] = items
		},
		setLoadedProduct(state, { type, item, url }) {
			item.timestamp = new Date()
			// console.log(item)
			state[type][url] = item
		},
	},
}
