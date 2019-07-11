<template>
	<v-container>
		<v-flex mb-4>
      <h1 class="display-1 font-weight-bold mb-3">
        All forms can be found here...
      </h1>
    </v-flex>
		<v-layout row>
      <v-flex xs12 sm6>
        
  
          <v-list three-line>
            <template v-for="(item, index) in forms">
            	<!-- <v-divider></v-divider> -->
              <v-list-tile
              	:key="item.form_id"
                :to="{ name: 'table', params: { tableId: item.form_id }}"
              >
                <v-list-tile-content>
                  <v-list-tile-title><strong>{{item.title}}</strong> [ {{item.form_id}} ]</v-list-tile-title>
                  <!-- <v-list-tile-sub-title>Form ID: [ {{item.form_id}} ]</v-list-tile-sub-title> -->
                  <v-list-tile-sub-title>Form Source:  <a target="_blank" :href="item.source">{{item.source}}</a></v-list-tile-sub-title>
                  <v-list-tile-sub-title>Last Updated: {{ item.last_update | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-divider
              v-if="index + 1 < forms.length"
              :key="index"
            ></v-divider>
            </template>
          </v-list>
      </v-flex>
    </v-layout>
	</v-container>
</template>

<script>
	import {clientUrl} from '@/config/config';
	import axios from 'axios';
  export default {
    data () {
    return {
      forms: []
    }
  }, 
  mounted() {
  	this.getListForms();
  },
  methods: {
  	async getListForms() {
  		try {
				const { data } = await axios.get(clientUrl,
				{
					params: {
      		get_forms: 1
      	}
    		});
			this.forms = JSON.parse(data);
			
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
