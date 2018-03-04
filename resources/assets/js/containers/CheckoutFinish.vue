<template>
	<div class="checkout row">
		<div class="product-content" v-if="cart.length">
			<div class="row">
				<div class="col-md-6 col-xs-7">
					<h1>Заказ:</h1>
					<div class="order-item" v-for="(item, index) in cart" :key="index">
						<div class="col-xs-12 col-sm-6">
							<div class="product-main-image">
								<img :src="/img/ + item.image">
							</div>
						</div>
						<div class="col-xs-12 col-sm-6">
							<div class="pull-right">
								<button class="btn btn-danger" @click="deleteFromCart(item.cart_id)">
									<i class="fa fa-times" aria-hidden="true"></i>
								</button>
							</div>
							<h4 class="no-margin">{{ item.title }}</h4>
							<h4 class="price-block">{{ item.count }} x {{ item.price }} руб.</h4>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xs-5">
					<h1>Итого:</h1>
					<h3 class="checkout-total">{{ total }} руб.</h3>
					<router-link to="/" class="logo-link btn btn-success">ЗАКАЗАТЬ</router-link>
				</div>
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
				total: 0,
			}
		},
		computed: {
			...mapGetters({
				cart: 'products/cart'
			})
		},
		methods: {
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
			
        },
	}
</script>