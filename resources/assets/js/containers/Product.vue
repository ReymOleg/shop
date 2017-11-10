<template>
	<div class="products">
		<div v-show="visible">
			<div>{{ product.title }}</div>
			<img :src="/img/ + product.image">
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