import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters/index'
import products from './modules/products.js'
import user from './modules/user.js'

// modules https://habrahabr.ru/post/322354/

Vue.use(Vuex)

export default new Vuex.Store({
	state: {},
	modules: {
		products: products,
		user: user,
	},
	// getters,
	// mutations: {
	// 	set(state, { type, items }) {
	// 		state[type] = items
	// 	}
	// },
	// actions: {
	// 	search({ commit }, query) {
	// 		const url = 'https://ru.wikipedia.org/w/api.php?action=query&format=json&list=search&srsearch=' + query

	// 		axios.get(url)
	// 	    .then(response => {
	// 			const results = response.query.search
	// 			commit('set', { type: 'results', items: results })
	// 	    })
	// 	    .catch(e => {
	// 	      throw e
	// 	    })
	// 	}
	// },
})
