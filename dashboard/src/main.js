import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import  Axios  from  'axios'

import './assets/css/pure-min.css'
import './assets/css/main.scss'

Vue.config.productionTip = false

Vue.prototype.$http = Axios

const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + token
}

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
