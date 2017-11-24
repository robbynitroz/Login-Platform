require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import { routes } from './routes/dashboard-routes';

Vue.use(VueRouter);
Vue.use(BootstrapVue);


const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes,
})


new Vue({
    el: '#app',
    router,
});