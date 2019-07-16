<template>
  <div>
    <h2>Login Page</h2>
    <form @submit.prevent="login_connect">
      <div>
          <input placeholder="Your email" type="text" v-model="login">
      </div>
      <div>
          <input placeholder="Password" type="password" v-model="password">
      </div>
      <div>
          <button type="submit">Login</button>
      </div>
    </form>
    <div>
          <button @click="">logout</button>
      </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        login : "admin",
        password : "qazwsx"
      }
    },
    methods: {
      async login_connect() {
        const login = this.login 
        const password = this.password
        try {
          const {data} = await this.$http.post('http://localhost/api-test/forms-api2/admin/token', {login, password});
          console.log(data)
          if (data && data.token) {
            localStorage.setItem('token', JSON.stringify(data.token));
            // this.$store.dispatch('login', login).then(() => this.$router.push('/'))
          } else {
            
          }
        } catch(err) {
          console.error(err.message)
        }
      },
      logout() {
        localStorage.removeItem('token');
        this.$store.dispatch('logout').then(() => this.$router.push('/login'))
      }
    }
  }
</script>