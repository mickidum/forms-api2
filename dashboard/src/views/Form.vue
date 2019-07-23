<template>
	<div v-if="form" class="single-form">
		<!-- <pre>{{form}}</pre> -->
		<!-- <pre v-if="form.settings">{{form.items}}</pre> -->
		<header class="single-form-header">
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
						<td>
							<div class="edit">
								<span>{{index + 1}} &nbsp;</span>
								<button 
								 class="pure-button button-primary button-xsmall button-secondary" 
								 @click="editItem(item)">
								 edit
								</button>
							</div>
							</td>
						<td v-for="i in item">{{i}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div v-if="editableItem" class="edit-modal">
			<div class="inner">
				<span class="close" @click="closeModal">&times;</span>
				<form @submit.prevent="saveItem" class="pure-form pure-form-stacked">
					<template v-for="(item, key) in editableItem">
						<label class="input-item" v-if="!ifArray(item)">
	      			{{key}}
							<input type="text" v-model="editableItem[key]">
						</label>
						<div class="is-array input-item" v-else>
				      <p>{{key}}</p>
							<input v-for="(i, index) in item" type="text" v-model="editableItem[key][index]" :placeholder="'name of ' + key">
						</div>
					</template>
					<p>
						<button type="submit" class="pure-button pure-button-primary">Save Item</button>
					</p>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import _ from 'lodash';
	export default {
		data() {
			return {
				checkedRows: [],
				selectAll: false,
				editableItem: null,
				test: 'sdsdsdsd'
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
				this.selectAll = false
			},
			editItem(item) {
				this.editableItem = item
				// console.log(this.editableItem)
			},
			saveItem(e) {
				console.log(this.editableItem)
			},
			flatArray(arr) {
				if(Array.isArray(arr)) {
					return arr.join(', ')
				}
				return arr
			},
			ifArray(arr) {
				if(Array.isArray(arr)) {
					return true
				}
				return false
			},
			closeModal() {
				this.editableItem = null
			}
		},
		mounted() {
			this.$store.dispatch('fillCurrentForm', this.$route.params.form_id)
		}
	}
</script>

<style lang="scss">
	
</style>