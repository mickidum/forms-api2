<template>
	<div class="inner">
		<span class="close" @click="closeModal">&times;</span>
		<form @submit.prevent="saveItem" class="pure-form pure-form-stacked">
			<div>
				<template v-for="(item, key) in editableItem">
					<label class="input-item" v-if="!ifArray(item)">
					      			{{key}}
						<input type="text" v-model="editableItem[key]">
					</label>
					<div class="is-array input-item" v-else>
			      <p>
			      	{{key}} 
			      	<span 
							 class="pure-button button-xsmall button-secondary" 
							 @click="addField(key)">
							 add field
							</span>
				    </p>
						<div class="delete-field" v-for="(i, index) in item">
							<input type="text" v-model="editableItem[key][index]" :placeholder="'name of ' + key">
							<span @click="delField(index, key)">-</span>
						</div>
					</div>
				</template>
			</div>
			<p>
				<button type="submit" class="pure-button pure-button-primary">Save Item</button>
			</p>
		</form>
	</div>
</template>

<script>
	export default {
		props: [
			'editableItem'
		],
		methods: {
			closeModal() {
				this.$emit('closeModal');
			},
			saveItem(item) {
				// console.log(this.editableItem)
				this.$emit('saveItem', item);
			},
			ifArray(arr) {
				if(Array.isArray(arr)) {
					return true
				}
				return false
			},
			addField(key) {
				this.editableItem[key].unshift('')
			},
			delField(index, key) {
				let upd = confirm('Delete this field?')
				if (!upd) {
					return
				}
				this.editableItem[key] = this.editableItem[key].filter((item, i) => {
					return i !== index
				})
			}
		}
	}
</script>

<style lang="scss" scoped>

</style>