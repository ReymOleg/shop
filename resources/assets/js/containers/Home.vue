<template>
	<div class="Results">
		<div class="Item" v-for="item in products">
			<div class="Item_title">{{ item.title }}</div>
			<div class="Item__url">{{ item.description }}</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		mounted() {
			this.$store._actions['products/getProducts'][0]();
        },
		computed: {
			products() {
				// console.log(this.$store.state.products.products);
				return this.$store.getters['products/getProducts']
			}
		},
	}
</script>