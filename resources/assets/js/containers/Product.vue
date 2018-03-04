<template>
	<div class="products">
		<div class="product-content" v-show="visible">
			<div class="col-xs-12 col-sm-6">
				<div class="product-main-image">
					<img :src="/img/ + product.image">
				</div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<h1 class="no-margin">{{ product.title }}</h1>
				<p class="product-price">{{ product.price }} руб.</p>
				<button @click="addToCart(product.id)" class="button primary">В корзину</button>
				<p>{{ product.description }}</p>
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
				visible: false
			}
		},
		computed: {
			...mapGetters({
				product: 'products/getProductOfUrl'
			})
		},
		methods: {
			...mapActions({
				getProduct: 'products/getProduct',
				toCart: 'products/addToCart'
			}),
			addToCart(productId) {
				let _self = this;

				this.$snotify.async(
					'Пожалуйста ожидайте',
					'В корзину',
					() => new Promise((resolve, reject) => {
			      _self.toCart(productId)
						.then((response) => {
							resolve({
					        title: 'Успешно!',
					        body: 'Товар добавлен в корзину!',
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
		mounted() {
			this.getProduct(this.$route.params[0])
        },
		watch: {
			'product': {
				handler: function() {
					this.visible = true
				}
			}
		}
	}
</script>