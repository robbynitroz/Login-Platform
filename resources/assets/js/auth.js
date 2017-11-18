require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { routes } from './routes/login-routes'

Vue.use(VueRouter);


const router = new VueRouter({
    mode: 'history',
    routes,
})


new Vue({
    el: '#app',
    router,
});



