<template>
	<div class="Results">
		<div class="Item" v-for="item in products">
			<router-link :to="{path: '/product/' + item.id }">
				<div class="Item_title">{{ item.title }}</div>
				<div class="Item__url">{{ item.description }}</div>
			</router-link>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		mounted() {
			this.$store._actions['products/getMainProducts'][0]()
        },
		computed: {
			products() {
				return this.$store.getters['products/getMainProducts']
			}
		},
	}
</script>