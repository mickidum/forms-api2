<template>
	<div v-if="form" class="single-form">
		<!-- <pre>{{n}}</pre> -->
		<!-- <pre v-if="form.settings">{{form.items}}</pre> -->
		<h1>{{ form.form_name }}</h1>
		<div class="scrollable">
			<table v-if="form.settings" class="single-form-table pure-table-striped pure-table pure-table-bordered">
				<thead>
					<tr>
						<th class="text-center">N</th>
						<th class="text-center" :key="index" v-for="(item, index) in form.settings.items_names">
							{{ item }}
						</th>
					</tr>
				</thead>
				<tbody>
					<form-item
					 v-for="(item, index) in form.items" 
					 :key="item.item_id" 
					 :item="item" 
					 :number="index + 1"
					/>	
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	import FormItem from '../components/FormItem'
	export default {
		components: {
			FormItem
		},
		computed: {
			form() {
				return this.$store.getters.getCurrentForm
			}
		},
		mounted() {
			this.$store.dispatch('fillCurrentForm', this.$route.params.form_id)
		}
	}
</script>

<style lang="scss">
	
</style>