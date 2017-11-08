import * as config from '../../config.js'

export default {
  namespaced: true,
	state: {
		products: [],
	},

  getters: {
    getProducts: (state, getters, rootState, rootGetters) => {
    	return state.products;
    }
  },

  actions: {
  	getProducts({commit}) {
	  	axios.get(config.url.products)
		    .then(response => {
					const products = response.data.products;
					// console.log(response);
					commit('set', { type: 'products', items: products })
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
