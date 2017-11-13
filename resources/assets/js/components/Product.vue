<template>
	<div class="product">
		<div class="product-container">
			<router-link :to="{path: '/product/' + item.url }">
				<div class="product-properties">
					<div class="product-title">{{ item.title }}</div>
				</div>
				<div class="product-image">
						<img :src="/img/ + item.image">
				</div>
			</router-link>
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