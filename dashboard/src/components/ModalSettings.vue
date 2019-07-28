<template>
	<div class="inner" v-if="settingsItem">
		<span class="close" @click="closeModal">&times;</span>
		<form @submit.prevent="saveSettings" class="pure-form pure-form-stacked">
				<!-- {{settingsItem}} -->
				<template v-if="settingsItem.items_names">
					<div class="heading">
						<span @click="toggleEditItems" class="pure-button button-xsmall button-warning">{{!editItems ? 'open' : 'close'}}</span>&nbsp;
						<strong>Items Names</strong>&nbsp;
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
						<strong>Validation</strong>&nbsp;
						<span>( set validation rules )</span>
					</div>
					<template v-if="editValidation">
						<div class="items-names">
							<span 
								@click="settingsItem.validation.validate = !settingsItem.validation.validate" 
								v-model="settingsItem.validation.validate" 
								:class="['pure-button button-xsmall', settingsItem.validation.validate ? 'button-error' : 'button-success']"
								>
								{{!settingsItem.validation.validate ? 'Validate' : 'Don\'t Validate'}}
							</span>

							<div class="validate-container" v-if="settingsItem.items_names">
								<strong>Items to validate</strong>
								<div v-for="item in settingsItem.items_names" class="validate-items">
									<label 
										v-if="item.name !== 'date'"
										:class="['custom-ch', checkValidate(item.name) ? 'custom-ch-checked' : null]"
									>
									<input type="checkbox" v-model="settingsItem.validation.validate_items" :value="item.name">
									</label>
									<span>{{item.name == 'date' ? null : item.title}}</span>
								</div>
							</div>

						</div>
					</template>
				</template>

				<template v-if="settingsItem.mail">
					<div class="heading">
						<span @click="toggleMailSending" class="pure-button button-xsmall button-warning">{{!editMailSending ? 'open' : 'close'}}</span>&nbsp;
						<strong>Mail Sending</strong>&nbsp;
						<span>( set email rules )</span>
					</div>
					<template v-if="editMailSending">
						<!-- <div v-for="item in settingsItem.items_names" class="items-names">
							<label class="settings-input-item">
						      			{{item.name}}
								<input type="text" v-model="item.title">
							</label>
						</div> -->
						{{settingsItem.mail}}
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
				editValidation: true,
				editMailSending: false
			}
		},
		props: [
			'settingsItem',
		],
		computed: {
			
		},
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
			},
			toggleMailSending() {
				this.editMailSending = !this.editMailSending
			},
			checkValidate(item) {
				let index = this.settingsItem.validation.validate_items.indexOf(item)
				if (index < 0) {
					return false
				}
				return true
			}
		}
	}
</script>