<template>
  <v-app>
    <v-toolbar app>
      <v-toolbar-title class="headline text-uppercase">
        <span>FORMS API 2</span>
        <span class="font-weight-light"> - mini crm</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn to="/" v-if="!isHome"  icon>
        <v-icon color="info">home</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon color="error">logout</v-icon>
      </v-btn>
    </v-toolbar>

    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>

export default {
  name: 'App',
  data () {
    return {
      //
    }
  },
  mounted() {
    // console.log(this.$route.name)
  },
  computed: {
    isHome() {
      return this.$route.name && this.$route.name == 'home';
    }
  }
}
</script>
