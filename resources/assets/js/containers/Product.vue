<template>
	<div class="products">
		<div class="product-content" v-show="visible">
			<div class="col-xs-6">
				<div class="product-main-image">
					<img :src="/img/ + product.image">
				</div>
			</div>
			<div class="col-xs-6">
				<h1 class="no-margin">{{ product.title }}</h1>
				<p class="product-price">{{ product.price }} рублей</p>
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
				getProduct: 'products/getProduct'
			})
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