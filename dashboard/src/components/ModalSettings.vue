<template>
	<div class="inner" v-if="settingsItem">
		<span class="close" @click="closeModal">&times;</span>
		<form @submit.prevent="saveSettings" class="pure-form pure-form-stacked">
				<!-- {{settingsItem}} -->
				<template v-if="settingsItem.items_names">
					<div class="heading">
						<span @click="toggleEditItems" class="pure-button button-xsmall button-warning">{{!editItems ? 'open' : 'close'}}</span>&nbsp;
						<h3>Items Names</h3>&nbsp;
						<span>( change items titles )</span>
					</div>
					<template v-if="editItems">
						<div v-for="item in settingsItem.items_names" class="items-names">
							<label class="settings-input-item">
						      			{{item.name}}
								<input type="text" v-model="item.title">
							</label>
						</div>
					</template>
				</template>

				<template v-if="settingsItem.validation">
					<div class="heading">
						<span @click="toggleEditValidation" class="pure-button button-xsmall button-warning">{{!editValidation ? 'open' : 'close'}}</span>&nbsp;
						<h3>Enable Validation</h3>&nbsp;
						<span>( set validation rules )</span>
					</div>
					<template v-if="editValidation">
						<!-- <div v-for="item in settingsItem.items_names" class="items-names">
							<label class="settings-input-item">
						      			{{item.name}}
								<input type="text" v-model="item.title">
							</label>
						</div> -->
						{{settingsItem.validation}}
					</template>
				</template>

				
				<!-- <pre>{{settingsItem}}</pre> -->
			<p>
				<button type="submit" class="pure-button pure-button-primary">Save Settings</button>&nbsp;
				<button @click.prevent="closeModal" class="pure-button button-secondary pure-button-primary">Cancel</button>
			</p>
		</form>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				editItems: false,
				editValidation: false,
				editMailSending: false
			}
		},
		props: [
			'settingsItem',
		],
		methods: {
			closeModal() {
				this.$emit('closeModal');
			},
			saveSettings() {
				this.$emit('saveSettings');
			},
			toggleEditItems() {
				this.editItems = !this.editItems
			},
			toggleEditValidation() {
				this.editValidation = !this.editValidation
			}
		}
	}
</script>