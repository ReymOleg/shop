import * as config from '../../config.js'
import * as Helpers from '../../helpers/Helpers.js'

export default {
  namespaced: true,
	state: {
		categoriesList: [],
		catCurrentProducts: {},
		catDownloadedProducts: {},
		catCurrentCategory: {},
		catDownloadedCategories: {},
	},
  getters: {
    getAllCategories: (state, getters, rootState, rootGetters) => {
    	return state.categoriesList
    },
    getProductsByCategory: (state, getters, rootState, rootGetters) => {
  		return state.catCurrentProducts || []
  	},
    getCategoryData: (state, getters, rootState, rootGetters) => {
        return state.catCurrentCategory || []
    }
  },
  actions: {
  	getAllCategories({commit}) {
  		let havingCategories = Helpers.getItems(this.state.categories, 'categoriesList');
  		if(havingCategories) {
  			commit('set', { type: 'main', items: havingCategories })
  		} else {
		  	axios.get(config.url.getAllCategories)
			    .then(response => {
					const categories = response.data.categories;
					commit('set', { type: 'categoriesList', items: categories })
			    })
			    .catch(e => {
			      throw e
			    })
  		}
  	},
  	getProductsByCategory({commit}, url) {
      let havingProducts = Helpers.getItemById(this.state.categories, 'catDownloadedProducts', url);
  		let havingCategories = Helpers.getItemById(this.state.categories, 'catDownloadedCategories', url);
  		if(havingProducts && havingCategories) {
            commit('set', { type: 'catCurrentProducts', items: havingProducts })
            commit('set', { type: 'catCurrentCategory', items: havingCategories })
          } else {
          axios.get(config.url.category + url)
            .then(response => {
              const products = response.data.products;
              const categories = response.data.categories;
              commit('set', { type: 'catCurrentProducts', items: products })
              commit('set', { type: 'catCurrentCategory', items: categories })
              commit('push', { type: 'catDownloadedProducts', key: url, items: products })
              commit('push', { type: 'catDownloadedCategories', key: url, items: categories })
  		    })
  		    .catch(e => {
  		      throw e
  		    })
  		}
  	}
  },
  mutations: {
		set(state, { type, items }) {
			state[type] = items
		},
		push(state, { type, key, items }) {
			state[type][key] = items
		},
	},
}
