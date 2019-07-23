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
								      <p>{{key}}</p>
						<input v-for="(i, index) in item" type="text" v-model="editableItem[key][index]" :placeholder="'name of ' + key">
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
		}
	}
</script>