<template>
	<div class="products-category" v-show="visible">
		<div class="categories" v-if="categories">
			<h1>
				<span v-if="categories.category && categories.category[0]">{{ categories.category[0].name }}</span>
				<span v-if="categories.subcategory && categories.subcategory[0]"> / {{ categories.subcategory[0].name }}</span>
			</h1>
		</div>
		<div class="products">
			<product v-for="(item, index) in products" :key="index" :item="item"></product>
		</div>
	</div>
</template>

<script type="text/javascript">
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'
import Product from '../components/Product.vue'

	export default {
		data() {
			return {
				visible: false
			}
		},
		computed: {
			...mapGetters({
				products: 'categories/getProductsByCategory',
				categories: 'categories/getCategoryData'
			})
		},
		methods: {
			...mapActions({
				getProductsByCategory: 'categories/getProductsByCategory'
			})
		},
		mounted() {
			this.getProductsByCategory(this.$route.params[0])
        },
		watch: {
			'products': {
				handler: function() {
					this.visible = true
				}
			}
		},
		components: { Product }
	}
</script>