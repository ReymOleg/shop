import * as config from '../../config.js'
import * as Helpers from '../../helpers/Helpers.js'

export default {
  namespaced: true,
	state: {
		main: [],
		searchAutocomplete: [],
		currentProduct: {},
		downloadedProducts: {},
		cart: {},
	},
  getters: {
    getMainProducts: (state, getters, rootState, rootGetters) => {
    	return state.main
    },
    searchAutocomplete: (state, getters, rootState, rootGetters) => {
    	return state.searchAutocomplete
    },
    getProductOfUrl: (state, getters, rootState, rootGetters) => {
  		return state.currentProduct || {}
  	},
  	cart: (state, getters, rootState, rootGetters) => {
  		return state.cart || {}
  	}
  },
  actions: {
  	getMainProducts({commit}) {
  		let havingProducts = Helpers.getItems(this.state.products, 'main');
  		if(havingProducts) {
  			commit('set', { type: 'main', items: havingProducts })
  		} else {
		  	axios.get(config.url.products)
			    .then(response => {
						const products = response.data.products;
						commit('set', { type: 'main', items: products })
			    })
			    .catch(e => {
			      throw e
			    })
  		}
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
  		let havingProduct = Helpers.getItemById(this.state.products, 'downloadedProducts', url);
		if(havingProduct) {
			commit('set', { type: 'currentProduct', items: havingProduct })
		} else {
  		axios.get(config.url.product + url)
		    .then(response => {
					const product = response.data.product;
					commit('set', { type: 'currentProduct', items: product[0] })
					commit('pushProducts', { type: 'downloadedProducts', key: url, items: product[0] })
		    })
		    .catch(e => {
		      throw e
		    })
		}
  	},
  	getCart({commit}) {
  		axios.get(config.url.getCart)
		    .then(response => {
				const cart = response.data.cart;
				commit('set', { type: 'cart', items: cart })
		    })
		    .catch(e => {
		      throw e
		    })
  	},
  	addToCart({commit}, productId) {
  		return new Promise((resolve, reject) => {
		  	axios(config.url.addToCart, {
	          method: 'post',
	          data: {
	          	product_id: productId
	          }
	        })
		    .then(response => {
					const cart = response.data.cart;
					commit('set', { type: 'cart', items: cart })
					resolve(response);
		    })
		    .catch(e => {
		      reject(e);
		      throw e
		    })
		})
  	},
  	deleteFromCart({commit}, cartId) {
  		return new Promise((resolve, reject) => {
		  	axios(config.url.deleteFromCart, {
	          method: 'post',
	          data: {
	          	cart_id: cartId
	          }
	        })
		    .then(response => {
					const cart = response.data.cart;
					commit('set', { type: 'cart', items: cart })
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
		},
		pushProducts(state, { type, key, items }) {
			state[type][key] = items
		}
	},
}
