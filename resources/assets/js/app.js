require('./bootstrap');

window.Vue = require('vue');
window.axios = require('axios');

window.axios.defaults.headers.common = {
	'X-CSRF-TOKEN': window.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

import Example from './components/Example.vue';


// Vue.component('example', require('./components/Example.vue'));


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app',
    render: h => h(Example),
});
