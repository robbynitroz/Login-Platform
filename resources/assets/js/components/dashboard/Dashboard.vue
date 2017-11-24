<template>
  <div class="app">
    <AppHeader/>
    <div class="app-body">
      <Sidebar :navItems="nav"/>
      <main class="main">
        <breadcrumb :list="list"/>
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
import { Header as AppHeader, Sidebar, Aside as AppAside, Footer as AppFooter, Breadcrumb } from './default-components/'

export default {
  name: 'Dashboard',
  components: {
    AppHeader,
    Sidebar,
    AppAside,
    AppFooter,
    Breadcrumb
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
  },

}
</script>
<style lang="scss">
  /* Import Font Awesome Icons Set */
  $fa-font-path: '~font-awesome/fonts/';
  @import '~font-awesome/css/font-awesome.min.css';
  /* Import Simple Line Icons Set */
  $simple-line-font-path: '~simple-line-icons/fonts/';
  @import '~simple-line-icons/css/simple-line-icons.css';
</style>
