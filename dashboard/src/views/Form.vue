<template>
	<div v-if="form" class="single-form">
		<!-- <pre>{{form}}</pre> -->
		<!-- <pre v-if="form.settings">{{form.items}}</pre> -->
		<header>
			<h1>{{ form.form_name }}</h1>
			<button v-if="checkedRows.length" class="pure-button button-error" @click="removeChecked">DELETE</button>
		</header>
		
		<div class="scrollable">
			<!-- {{checkedRows}} -->
			<table class="pure-table single-form-table pure-table-bordered">
				<thead v-if="itemsNames">
					<tr>
						<th class="check"><input v-model="selectAll" @change="checkAll" type="checkbox" :value="items"></th>
						<th>#</th>
						<th v-for="item in itemsNames">{{item.title}}</th>
					</tr>
				</thead>
				<tbody v-if="items">
					<tr v-for="(item, index) in items">
						<td class="check"><input v-model="checkedRows" :value="item" type="checkbox"></td>
						<td>{{index + 1}}</td>
						<td v-for="i in item">{{i}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script>
	import _ from 'lodash';
	export default {
		data() {
			return {
				checkedRows: [],
				selectAll: false
			}
		},
		computed: {
			form() {
				return this.$store.getters.getCurrentForm
			},
			itemsNames() {
				return this.form.settings.items_names
			},
			items() {
				return this.form.items
			}
		},
		methods: {
			checkAll() {
				this.selectAll ? this.checkedRows = this.items : this.checkedRows = []
			},
			removeChecked() {
				// confirm('Delete Checked Items?')
				let items = _.difference(this.items, this.checkedRows);
				this.$store.dispatch('removeCheckedItems', items)
				this.checkedRows = []
			}
		},
		mounted() {
			this.$store.dispatch('fillCurrentForm', this.$route.params.form_id)
		}
	}
</script>

<style lang="scss">
	
</style>