<template>
	<div class="header-search">
		<input
			class="col-sm-10 col-xs-8"
			type="text"
			v-model="query"
			@input="search()"
			@focus="search()"
			@blur="hide()"
			placeholder="Поиск..."
		>
		<button class="col-sm-2 col-xs-4 search-button" type="submit">
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
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'

	export default {
		data() {
			return {
				query: '',
				visible: false,
			}
		},
		methods: {
			...mapActions({
				searchAutocomplete: 'products/searchAutocomplete'
			}),
			search() {
				this.visible = true
				this.searchAutocomplete(this.query)
			},
			hide() {
				let _self = this;
				setTimeout(function() {
					_self.visible = false
				}, 100);
			}
		},
		computed: {
			...mapGetters({
				products: 'products/searchAutocomplete',
			})
		}
	}
</script>