<template>
	<div class="products">
		<product v-for="(item, index) in products" :key="index" :item="item"></product>
	</div>
</template>

<script type="text/javascript">
	import Product from '../components/Product.vue'
	import { mapGetters } from 'vuex'
	import { mapActions } from 'vuex'

	export default {
		computed: {
			...mapGetters({
				products: 'products/getMainProducts'
			})
		},
		methods: {
			...mapActions({
				getMainProducts: 'products/getMainProducts'
			})
		},
		mounted() {
			this.getMainProducts()
        },
  		components: { Product },
		name: 'app',
	}
</script>