import Brands from './containers/Brands.vue'
import Contacts from './containers/Contacts.vue'
import Home from './containers/Home.vue'
// import Clients from './components/passport/Clients.vue'
// import AuthorizedClients from './components/passport/AuthorizedClients.vue'
// import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue'


const routes = [
		{ path: '/', component: Home},
		{ path: '/brands', component: Brands},
		{ path: '/contacts', component: Contacts},
		// { path: '/passport-clients', component: Clients},
		// { path: '/passport-authorized-clients', component: AuthorizedClients},
		// { path: '/passport-personal-access-tokens', component: PersonalAccessTokens},
	];

// const routes = [
//   { path: '/login', component: LoginView}, 
//   { path: '/', component: DashView, auth: true,
//     children: [
//       { path: '', component: DashboardView, name: 'Dashboard' }, 
//       { path: '/tables', component: TablesView, name: 'Tables',
//     ]
//   }, 
//   { path: '*', component: NotFoundView }
// ]

export default routes