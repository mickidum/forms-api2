<template>
	<div class="list">
		<h1>All Forms Here</h1>
		<div v-if="allForms" class="list">
			{{allForms}}
			<ol>
				<li v-for="item in allForms" :key="item.form_id">
					<router-link :to="{ name: 'form', params: { form_id: item.form_id }}">{{item.title}}</router-link>
				</li>
			</ol>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'FormList',
		computed: {
			allForms() {
				return this.$store.getters.getAllForms 
			}
		},
		mounted() {
			this.$store.dispatch('fillForms')
		},
		methods: {
			
		}
	}
</script>