require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import routes from './routes.js'
import App from './App.vue'
import store from './store'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    render: h => h(App), 
    store: store,
    router: router
});
