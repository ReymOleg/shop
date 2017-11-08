<template>
	<div class="Results">
		<div class="Item" v-for="item in results">
			<a :href="item.url" class="Item_title">{{ item.title }}</a>
			<div class="Item__url">{{ item.url }}</div>
			<div class="Item__snippet" v-html="item.snippet"></div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		computed: {
			results() {
				return this.$store.getters.results
			}
		}
	}
</script>