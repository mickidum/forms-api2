<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link> |
      <router-link to="/form-list">Form List</router-link>
      <span v-if="isLoggedIn"> | <a @click="logout">Logout</a></span>
      <span v-else>  | <router-link to="/login">Login</router-link></span>
    </div>
    <router-view/>
  </div>
</template>

<script>
  
  export default {
    computed : {
      isLoggedIn(){ 
        return this.$store.getters.isLoggedIn
      },
      getTime() {
        return Math.floor(Date.now() / 1000)
      }
    },
    methods: {
      logout() {
        this.$store.dispatch('logout')
        .then(() => {
          this.$router.push('/login')
        })
      },
      refreshToken() {
        let now = +this.getTime
        let expires = +localStorage.getItem('expires') || now
        console.log(expires)
        console.log(now)
        let refresh = expires - now;
        console.log('Refresh :', refresh);
        if (refresh > 0) {
          let start = setInterval(() => {
            console.log('ping')
          }, refresh * 1000)
        }
      }
    },
    created() {
      // this.refreshToken()
	  }
  }
</script>