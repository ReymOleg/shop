<template>
	<div class="products">
		<product v-for="(item, index) in products" :key="index" :item="item"></product>
		<product v-for="(item, index) in products" :key="index" :item="item"></product>
	</div>
</template>

<script type="text/javascript">
	import Product from '../components/Product.vue'

	export default {
		mounted() {
			this.$store._actions['products/getMainProducts'][0]()
        },
		computed: {
			products() {
				return this.$store.getters['products/getMainProducts']
			}
		},
  		components: { Product },
		name: 'app',
	}
</script>