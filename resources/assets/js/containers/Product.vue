<template>
	<div class="products">
		<div>{{ show }}</div>
		<div v-show="show">
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
				show: false,
			}
		},
		computed: {
			...mapGetters({
				product: 'products/getProductOfUrl'
			}),
		},
		methods: {
			...mapActions({
				'getProduct': 'products/getProduct'
			}),
		},
		mounted() {
			this.getProduct(this.$route.params[0])
        },
		watch: {
			'product': {
				handler: function(after, before) {
					console.log(after, before);
					this.show = true
				},
				deep: true
			}
		}
	}
</script>