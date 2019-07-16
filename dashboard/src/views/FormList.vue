<template>
	<div class="list">
		<h1>All Forms Here</h1>
		<div class="list">
			{{allForms}}
		</div>
	</div>
</template>

<script>
	export default {
		name: 'FormList',
		computed: {
			allForms() {
				return this.$store.getters.getAllFroms
			}
		},
		mounted() {
			if (!this.allForms.length) {
				this.$store.dispatch('fillForms')
			}
		},
		methods: {
			
		}
	}
</script>