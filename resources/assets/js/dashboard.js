require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import { routes } from './routes/dashboard-routes';

Vue.use(VueRouter);
Vue.use(BootstrapVue);


const router = new VueRouter({
    mode: 'history',
    routes,
})


new Vue({
    el: '#app',
    router,
});