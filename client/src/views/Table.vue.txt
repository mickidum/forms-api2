<template>
	<v-container v-if="form">
		<h1 class="mb-3">{{form.form_name}}</h1>
      <v-data-table
        v-model="selected"
        :headers="headers"
        :items="items"
        :pagination.sync="pagination"
        select-all
        item-key="item_id"
        class="elevation-1"
      >
    <template v-slot:headers="props">
        <tr>
          <th>
            <v-checkbox
              :input-value="props.all"
              :indeterminate="props.indeterminate"
              primary
              hide-details
              @click.stop="toggleAll"
            ></v-checkbox>
          </th>
          <th
            v-for="header in props.headers"
            :key="header.text"
            :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
            @click="changeSort(header.value)"
          >
            <v-icon small>arrow_upward</v-icon>
            {{ header.text }}
          </th>
        </tr>
      </template>
      <template v-slot:items="props">
        <tr :active="props.selected" @click="props.selected = !props.selected">
          <td>
            <v-checkbox
              :input-value="props.selected"
              primary
              hide-details
            ></v-checkbox>
          </td>
          <!-- <td>{{ props.item.item_id }}</td> -->
          <td class="text-xs-center" :key="item_id" v-for="(item, index) in props.item"><v-edit-dialog
            :return-value.sync="props.item"
            lazy
            @save="save"
            @cancel="cancel"
            @open="open"
            @close="close"
          > {{ item }}
            <template v-slot:input>
              <v-text-field
                v-model="props.item"
                :rules="[max25chars]"
                label="Edit"
                single-line
                counter
              ></v-text-field>
            </template>
          </v-edit-dialog>
        </td>
        </tr>
      </template>
    </v-data-table>
	</v-container>
</template>

<script>
	import {clientUrl} from '@/config/config';
	import axios from 'axios';
  export default {
    data () {
    return {
      form: null,
      headers: [],
      items: [],
      selected: [],
    }
  }, 
  mounted() {
  	this.getTable();
  },
  methods: {
  	async getTable() {
  		try {
				const { data } = await axios.get(clientUrl,
				{
					params: {
      		get_form: this.$route.params.tableId
      	}
    		});
			this.form = JSON.parse(data);
      this.headers = this.form.settings.items_names.map(item => {
        let obj = {
          text: item,
          value: item
        }
        return obj;
      });
      // console.log(this.headers)
      this.items = this.form.items;
			
			// console.log(JSON.parse(data));
  		} catch(err) {
  			console.error(err);
  		}
			
  	}
  	// getListForms() {
  	// 	axios.get(clientUrl, {params: {get_forms: 1}})
  	// 	.then(response => {
  	// 		console.log(response.data)
  	// 	})
  	// }
  }
}
</script>
