import {routes} from "./routes/dashboard-routes";

require('./bootstrap');
require('es6-promise').polyfill();

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import VueRouter from 'vue-router';



import MainPage from './components/newsfeed/MainPage.vue'

Vue.use(BootstrapVue);
Vue.use(VueRouter)


const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes,
})

new Vue({
    el: '#app',
    router,
    components:{
        MainPage
    }
});


