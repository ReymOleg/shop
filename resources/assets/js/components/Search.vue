<template>
	<div class="header-search">
		<input
			class="col-xs-10"
			type="text"
			v-model="query"
			@keyup="search()"
			@blur="hide()"
			placeholder="Поиск..."
		>
		<button class="col-xs-2 search-button" type="submit">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
		<div class="autocomplete" v-if="products && query">
			<div v-for="item in products">
				<router-link :to="{path: '/product/' + item.id }">{{ item.title }}</router-link>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data() {
			return {
				query: '',
			}
		},
		methods: {
			search() {
				this.$store._actions['products/search'][0](this.query)
				console.log(this.$store);
			},
			hide() {
				this.query = ''
			}
		},
		computed: {
			products() {
				return this.$store.getters['products/search']
			}
		}
	}
</script>