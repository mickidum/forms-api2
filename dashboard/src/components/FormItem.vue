<template>
	<tr v-if="item" @click="selectRow(item)">
		<td>
			{{number}}
		</td>
		<td v-for="(i, index) in item" :key="index">{{ flatArray(i) }}</td>
	</tr>
</template>

<script>
	export default {
		props: [
			"item",
			"number"
		],
		methods: {
			flatArray(arr) {
				if(Array.isArray(arr)) {
					return arr.join(', ')
				}
				return arr
			},
			selectRow(id) {
				this.$emit('selectRow', id);
			}
		}
	}
</script>