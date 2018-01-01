<template>
	<div class="cart-container">
		<div class="cart-entity">
			<div class="cart-products">
				<div class="cart-item" v-for="(item, index) in cart" :key="index">
					<div class="cart-image">
						<router-link :to="{path: '/product/' + item.url }">
							<img :src="/img/ + item.image">
						</router-link>
					</div>
					<div class="cart-props">
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
					<div class="pull-left">
						Оформить заказ
					</div>
					<div class="pull-right">
						Итого: {{ total }} руб.
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
				deleteFromCart: 'products/deleteFromCart'
			})
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