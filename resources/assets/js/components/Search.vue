<template>
	<div class="header-search">
		<input
			class="col-xs-10"
			type="text"
			v-model="query"
			@input="search()"
			@focus="search()"
			@blur="hide()"
			placeholder="Поиск..."
		>
		<button class="col-xs-2 search-button" type="submit">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
		<div class="autocomplete" v-if="visible && query">
			<div v-for="item in products">
				<router-link :to="{path: '/product/' + item.url }">{{ item.title }}</router-link>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data() {
			return {
				query: '',
				visible: false,
			}
		},
		methods: {
			search() {
				this.visible = true
				this.$store._actions['products/searchAutocomplete'][0](this.query)
			},
			hide() {
				let _self = this;
				setTimeout(function() {
					_self.visible = false
				}, 100);
			}
		},
		computed: {
			products() {
				return this.$store.getters['products/searchAutocomplete']
			}
		}
	}
</script>