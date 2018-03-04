<template>
	<div class="cart-container">
		<div class="cart-entity">
			<div class="cart-products">
				<div class="cart-item" v-for="(item, index) in cart" :key="index">
					<div class="cart-image" @click="cartClose()">
						<router-link :to="{path: '/product/' + item.url }">
							<img :src="/img/ + item.image">
						</router-link>
					</div>
					<div class="cart-props"  @click="cartClose()">
						<router-link :to="{path: '/product/' + item.url }">
							<p class="no-margin">{{ item.title }}</p>
						</router-link>
						<p class="no-margin">{{ item.count }} x {{ item.price }} руб.</p>
					</div>
					<div class="cart-actions">
						<button @click="deleteFromCart(item.cart_id)" class="btn-transparent red">
							<i class="fa fa-times" aria-hidden="true"></i>
						</button>
					</div>
				</div>
				<div v-if="cart.length">
					<hr>
					<div class="pull-right text-right">
						<span>Итого: {{ total }} руб.</span>
						<span @click="cartClose()">
							<router-link :to="'/checkout/'" class="btn btn-primary">Оформить заказ</router-link>
						</span>
					</div>
				</div>
				<div v-else>
					Ваша корзина пуста
				</div>
			</div>
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
		mounted() {
			// this.total = 
			// console.log(this.cart);
			// for (let item in this.cart) {
			// 	console.log(item);
			// }
        },
		computed: {
			...mapGetters({
				cart: 'products/cart'
			})
		},
		methods: {
			...mapActions({
				deleteProductFromCart: 'products/deleteFromCart'
			}),
			cartClose() {
				this.$options.parent.cartClose()
				// console.log(this);
				// this.props.cartClose();
				// this.$parent.$options.methods.cartClose()
			},
			deleteFromCart(productId) {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'Удаление',
					() => new Promise((resolve, reject) => {
			      _self.deleteProductFromCart(productId)
							.then((response) => {
								resolve({
						        title: 'Успешно!',
						        body: 'Товар удален из корзины!',
						        config: {
						          closeOnClick: true,
						          timeout: 2000
						        }
					      })
					    })
					    .catch((e) => {
					    	reject({
					        title: 'Ошибка!',
					        body: 'Что-то пошло не так...',
					        config: {
					          closeOnClick: true,
					          timeout: 3000
					        }
					      })
					    })
				  	})
			  	)
			}
		},
		watch: {
			'cart': {
				handler: function(items) {
					this.total = 0;
					for (let i in items) {
						this.total += items[i].price * items[i].count
					}
				}
			}
		},
	}
</script>