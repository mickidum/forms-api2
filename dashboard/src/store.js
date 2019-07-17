import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

const apiUrl = 'http://localhost/api-test/forms-api2/admin';

export default new Vuex.Store({
  state: {
    status: '',
    token: localStorage.getItem('token') || '',
    user : {},
    allForms: [],
    currentForm: {}
  },
  mutations: {
	  auth_request(state){
	    state.status = 'loading'
	  },
	  auth_success(state, token, user){
	    state.status = 'success'
	    state.token = token
	    state.user = user
	  },
	  auth_error(state){
	    state.status = 'error'
	  },
	  logout(state){
	    state.status = ''
	    state.token = ''
	  },
	  fillForms(state, allForms){
	    state.allForms = allForms
	  },
	  currentForm(state, form){
	    state.currentForm = form
	  },
	},
  actions: {
		login({commit}, user){
	      commit('auth_request')
	      axios({url: `${apiUrl}/token`, data: user, method: 'POST' })
	      .then(resp => {
	        const token = resp.data.token
	        const user = resp.data.user
	        localStorage.setItem('token', token)
	        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
	        commit('auth_success', token, user)
	      })
	      .catch(err => {
	        commit('auth_error')
	        localStorage.removeItem('token')
	      })
		},
		logout({commit}){
				commit('logout')
				delete axios.defaults.headers.common['Authorization']
				localStorage.removeItem('token')
		},
		fillForms({commit}){
			axios.get(`${apiUrl}/getlist`)
			.then(resp => {
				const allForms = resp.data ? resp.data : []
				commit('fillForms', allForms)
			})
			.catch(err => {
				if (err.response.status === 401) {
					this.dispatch('logout')
				}
			})
		},
		fillCurrentForm({commit}, form_id){
			axios.get(`${apiUrl}/getform/${form_id}`)
			.then(resp => {
				const form = resp.data ? resp.data : {}
				commit('currentForm', form)
			})
			.catch(err => {
				console.log(err.response)
				if (err.response.status === 401) {
					this.dispatch('logout')
				}
			})
		}
  },
  getters : {
	  isLoggedIn: state => !!state.token,
	  authStatus: state => state.status,
	  getAllForms: state => state.allForms,
	  getCurrentForm: state => state.currentForm,
	  
	}
})
