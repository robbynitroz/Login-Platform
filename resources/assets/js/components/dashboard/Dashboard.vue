<template>
  <div class="app">
    <AppHeader/>
    <div class="app-body">
      <Sidebar :navItems="nav"/>
      <main class="main">

        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
      <AppAside/>
    </div>
    <AppFooter/>
  </div>
</template>

<script>
import nav from './_nav'
import { Header as AppHeader, Sidebar, Aside as AppAside, Footer as AppFooter } from './child-components/'

export default {
  name: 'Dashboard',
  components: {
    AppHeader,
    Sidebar,
    AppAside,
    AppFooter,
    //Breadcrumb
  },
  data () {
    return {
      nav: nav.items
    }
  },
  computed: {
    name () {
      return this.$route.name
    },
    list () {
      return this.$route.matched
    }
  }
}
</script>
