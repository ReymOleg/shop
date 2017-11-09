<template>
	<div class="product col-xs-3">
		<div class="product-container">
			<div class="product-properties">
				<div class="product-title">{{ item.title }}</div>
			</div>
			<div class="product-image">
				<router-link :to="{path: '/product/' + item.url }">
					<img :src="/img/ + item.image">
				</router-link>
			</div>
			<div class="product-properties">
				<div class="product-price">{{ item.price }} рублей</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: ['item'],
		data() {
			return {
				fromCart: false,
			}
		},
		methods: {

		},
		computed: {
			// fu() {
			// 	console.log(this.data);
			// }
		}
	}
</script>