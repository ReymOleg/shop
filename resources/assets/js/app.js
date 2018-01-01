require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import routes from './routes.js'
import App from './App.vue'
import store from './store'

import VueCookie from 'vue-cookie';
Vue.use(VueCookie);

import axiosRetry from 'axios-retry';
axiosRetry(axios, { retries: 2 });


Vue.use(VueRouter)

const router = new VueRouter({
    routes: routes,
    mode: 'history'
});

Vue.directive('click-outside', {
  bind: function (el, binding, vnode) {
    el.event = function (event) {
      // here I check that click was outside the el and his childrens
      if (!(el == event.target || el.contains(event.target))) {
        // and if it did, call method provided in attribute value
        vnode.context[binding.expression](event);
      }
    };
    document.body.addEventListener('click', el.event)
  },
  unbind: function (el) {
    document.body.removeEventListener('click', el.event)
  },
});

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
