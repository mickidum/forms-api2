<template>
	<div v-if="form" class="single-form">
		<!-- <pre>{{form}}</pre> -->
		<!-- <pre v-if="form.settings">{{form.items}}</pre> -->
		<span class="settings" @click="removeChecked">Settings</span>
		<header class="single-form-header">
			<h1>{{ form.form_name }}</h1>
			<button v-if="checkedRows.length" class="pure-button button-error" @click="removeChecked">Delete Row</button>
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
			<modal-edit
			:editableItem="editableItem"
			@closeModal="closeModal"
			@saveItem="saveItem(editableItem)"
			></modal-edit>
		</div>
	</div>
</template>

<script>
	import _ from 'lodash';
	import ModalEdit from '../components/ModalEdit';
	export default {
		components: {
			ModalEdit
		},
		data() {
			return {
				checkedRows: [],
				selectAll: false,
				editableItem: null,
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
			},
			settings() {
				return this.form.settings
			}
		},
		methods: {
			checkAll() {
				this.selectAll ? this.checkedRows = this.items : this.checkedRows = []
			},
			removeChecked() {
				// confirm('Delete Checked Items?')
				let items = _.difference(this.items, this.checkedRows);
				this.updateForm(items) 
				this.checkedRows = []
				this.selectAll = false
			},
			editItem(item) {
				this.editableItem = item
			},
			saveItem(item) {
				const index = _.findIndex(this.items, { 'item_id':  item.item_id})
				const items = this.items
				items.splice(index, 1, item)
				this.updateForm(items)
				this.closeModal()
			},
			flatArray(arr) {
				if(Array.isArray(arr)) {
					return arr.join(', ')
				}
				return arr
			},
			updateForm(items) {
				const form = this.form
				form.items = items
				this.$store.dispatch('updateCurrentForm', form)
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