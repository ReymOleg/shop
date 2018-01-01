export const apiUrl = '/api';

export const url = {
	product: apiUrl + '/product/',
	products: apiUrl + '/products/',
	// searchAutocomplete: apiUrl + 'products/search/', // returns not api result
	searchAutocomplete: apiUrl + '/products/searchAutocomplete/',
	login: apiUrl + '/user/login',
	logout: apiUrl + '/user/logout',
	checkAuth: apiUrl + '/user/checkAuth',
	createUser: apiUrl + '/user/create',
	category: apiUrl + '/category/',
	getAllCategories: apiUrl + '/categories',
	getCart: apiUrl + '/cart',
	addToCart: apiUrl + '/cart/add',
	deleteFromCart: apiUrl + '/cart/delete',
}