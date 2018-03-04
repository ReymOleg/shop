<template>
	<div class="checkout-finish row">
		<div v-if="cart.length">
			<div class="row">
				<div class="col-sm-3 xs-hidden"></div>
				<div class="col-xs-12 col-sm-6">
					<h1>Завершение заказа</h1>
					<h4><i>Наш менеджер свяжется с Вами в ближайшее время</i></h4>
					<div class="checkout-finish-form">
						<div class="input-field">
				        	<input type="text" id="checkout-email" placeholder="Email" v-model="checkoutFields.email">
						</div>
						<div class="input-field">
				        	<input type="text" id="checkout-phone" placeholder="Телефон" v-model="checkoutFields.phone">
						</div>
						<div class="input-field">
				        	<input type="text" id="checkout-name" placeholder="Ваше имя" v-model="checkoutFields.name">
						</div>
						<br>
						<button @click="checkout()" class="btn btn-success">ОФОРМИТЬ ЗАКАЗ</button>
					</div>
				</div>
				<div class="col-sm-3 xs-hidden"></div>
			</div>
		</div>
		<div v-else>
			<h1>Выберите что-нибудь, что бы заказать...</h1>
		</div>
	</div>
</template>

<script type="text/javascript">
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'

	export default {
		data() {
			return {
				checkoutFields: {
					email: '',
					phone: '',
					name: '',
				},
			}
		},
		computed: {
			...mapGetters({
				cart: 'products/cart',
				userData: 'user/userData',
			})
		},
		methods: {
			...mapActions({
				orderCheckout: 'products/checkout',
			}),
			checkout() {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'Заказ',
					() => new Promise((resolve, reject) => {
			      _self.orderCheckout(_self.checkoutFields)
							.then((response) => {
								resolve({
						        title: 'Успешно!',
						        body: 'Ваш заказ в обработке!',
						        config: {
						          closeOnClick: true,
						          timeout: 2000
						        }
					      })
					    })
					    .catch((e) => {
					    	let error = '';
					    	if (e.data && e.data.errors) {
					    		for (let i in e.data.errors) {
					    			error += e.data.errors[i] + '\n\t';
					    		}
					    	} else {
					    		error = 'Проверьте правильность полей';
					    	}
					    	reject({
					        title: 'Ошибка!',
					        body: error,
					        config: {
					          closeOnClick: true,
					          // timeout: 3000
					        }
					      })
					    })
				  	})
			  	)
			}
			// deleteFromCart(productId) {
			// 	let _self = this;

			// 	this.$snotify.async(
			// 		'Пожалуйста ожидайте',
			// 		'Удаление',
			// 		() => new Promise((resolve, reject) => {
			//       _self.deleteProductFromCart(productId)
			// 				.then((response) => {
			// 					resolve({
			// 			        title: 'Успешно!',
			// 			        body: 'Товар удален из корзины!',
			// 			        config: {
			// 			          closeOnClick: true,
			// 			          timeout: 2000
			// 			        }
			// 		      })
			// 		    })
			// 		    .catch((e) => {
			// 		    	reject({
			// 		        title: 'Ошибка!',
			// 		        body: 'Что-то пошло не так...',
			// 		        config: {
			// 		          closeOnClick: true,
			// 		          timeout: 3000
			// 		        }
			// 		      })
			// 		    })
			// 	  	})
			//   	)
			// }
		},
		mounted() {
			this.checkoutFields.email = this.userData.email;
			this.checkoutFields.phone = this.userData.phone;
			this.checkoutFields.name = this.userData.name;
        },
	}
</script>