require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import routes from './routes.js'
import App from './App.vue'
import store from './store'

import axiosRetry from 'axios-retry';
axiosRetry(axios, { retries: 2 });

Vue.use(VueRouter)

const router = new VueRouter({
    routes: routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    render: h => h(App), 
    store: store,
    router: router,
 //    data: {
	// 	user: false
	// },
	// methods: {
	// 	checkIfLogged(){
	//         return new Promise((resolve, reject) => {
	//           axios.get('/api/sessionStatus')
	//              .then(response => {
	//                 resolve(response.data.user);
	//              })
	//              .catch(error => {
	//                 reject(error.response.data);
	//              });
	//         }) 
	//     }
	// },
 //    created(){
	// 	this.checkIfLogged()
	// 		.then(response => {
	// 			console.log(response)
	// 			this.user = response ? response : false;
	// 		})                    
	// 		.catch(error => {
	// 			console.log(error)
	// 		});
 //    }
});
