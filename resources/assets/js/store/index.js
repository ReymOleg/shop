require('es6-promise').polyfill(); // Fucking IE

import Vue from 'vue'
import Vuex from 'vuex'
import products from './modules/products.js'
import user from './modules/user.js'
import categories from './modules/categories.js'

// modules https://habrahabr.ru/post/322354/

Vue.use(Vuex)

export default new Vuex.Store({
	state: {},
	modules: {
		products: products,
		user: user,
		categories: categories,
	}
})
