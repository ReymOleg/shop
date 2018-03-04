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
					<button class="btn btn-success">ЗАКАЗАТЬ</button>
				</div>
			</div>
		</div>
		<div v-else>
			<h1>Ваша корзина пуста</h1>
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
			...mapActions({
				deleteFromCart: 'products/deleteFromCart',
				getCart: 'products/getCart'
			}),
			calculateCart(items) {
				this.total = 0;
				for (let i in items) {
					this.total += items[i].price * items[i].count
				}
			}
		},
		mounted() {
			this.getCart()
        },
        watch: {
			'cart': {
				handler: function(items) {
					this.calculateCart(items)
				}
			}
		},
	}
</script>