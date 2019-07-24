<template>
	<div class="inner">
		<span class="close" @click="closeModal">&times;</span>
		<form @submit.prevent="saveItem" class="pure-form pure-form-stacked">
			<div>
				<!-- {{settingsItem}} -->
				<template v-for="(item, key) in settingsItem">
					<!-- <label class="input-item" v-if="!ifArray(item)">
					      			{{key}}
						<input type="text" v-model="settingsItem[key]">
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
							<input type="text" v-model="settingsItem[key][index]" :placeholder="'name of ' + key">
							<span @click="delField(index, key)">-</span>
						</div>
					</div> -->
					<pre>{{key}} : {{item}}</pre>
				</template>
			</div>
			<p>
				<button type="submit" class="pure-button pure-button-primary">Save Settings</button>
			</p>
		</form>
	</div>
</template>

<script>
	export default {
		props: [
			'settingsItem'
		],
		methods: {
			closeModal() {
				this.$emit('closeModal');
			},
			saveItem(item) {
				this.$emit('saveItem', item);
			}
		}
	}
</script>