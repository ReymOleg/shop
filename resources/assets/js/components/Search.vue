<template>
	<div class="Search">
		<input type="text" class="Search__input" v-model="query">
		<button class="Search__button" @click="search()">Найти</button>
	</div>
</template>

<script type="text/javascript">
import store from '../store/index.js'

	export default {
		data() {
			return {
				query: ''
			}
		},
		methods: {
			search() {
				this.$store.dispatch('search', this.query)
			}
		}
	}
</script>